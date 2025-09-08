<?php
// Google Calendar API Configuration
// This file handles Google Calendar integration for booking availability

require_once __DIR__ . '/../vendor/autoload.php';

class GoogleCalendarService {
    private $service;
    private $calendarId;
    
    public function __construct() {
        $this->calendarId = 'primary'; // Change this to your shared calendar ID
        
        // Initialize Google Client
        $client = new Google_Client();
        $client->setApplicationName('FluxTerra Simworks');
        $client->setScopes(Google_Service_Calendar::CALENDAR);
        $client->setAuthConfig(__DIR__ . '/google-credentials.json');
        
        $this->service = new Google_Service_Calendar($client);
    }
    
    /**
     * Get available time slots for a given date
     */
    public function getAvailableSlots($date, $duration = 60) {
        try {
            $startTime = $date . 'T00:00:00Z';
            $endTime = $date . 'T23:59:59Z';
            
            $optParams = array(
                'timeMin' => $startTime,
                'timeMax' => $endTime,
                'singleEvents' => true,
                'orderBy' => 'startTime'
            );
            
            $events = $this->service->events->listEvents($this->calendarId, $optParams);
            
            $busySlots = [];
            foreach ($events->getItems() as $event) {
                $start = $event->getStart()->getDateTime();
                $end = $event->getEnd()->getDateTime();
                
                if ($start && $end) {
                    $busySlots[] = [
                        'start' => new DateTime($start),
                        'end' => new DateTime($end)
                    ];
                }
            }
            
            return $this->calculateAvailableSlots($date, $busySlots, $duration);
            
        } catch (Exception $e) {
            error_log('Google Calendar API Error: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Create a booking event
     */
    public function createBooking($title, $startDateTime, $endDateTime, $description = '') {
        try {
            $event = new Google_Service_Calendar_Event(array(
                'summary' => $title,
                'description' => $description,
                'start' => array(
                    'dateTime' => $startDateTime,
                    'timeZone' => 'America/New_York', // Adjust timezone as needed
                ),
                'end' => array(
                    'dateTime' => $endDateTime,
                    'timeZone' => 'America/New_York',
                ),
                'reminders' => array(
                    'useDefault' => false,
                    'overrides' => array(
                        array('method' => 'email', 'minutes' => 24 * 60),
                        array('method' => 'popup', 'minutes' => 10),
                    ),
                ),
            ));
            
            $event = $this->service->events->insert($this->calendarId, $event);
            return $event->getId();
            
        } catch (Exception $e) {
            error_log('Google Calendar Create Event Error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Calculate available time slots
     */
    private function calculateAvailableSlots($date, $busySlots, $duration) {
        $availableSlots = [];
        $workingHours = [
            'start' => 9,  // 9 AM
            'end' => 22    // 10 PM
        ];
        
        $currentTime = new DateTime($date . ' ' . sprintf('%02d:00', $workingHours['start']));
        $endTime = new DateTime($date . ' ' . sprintf('%02d:00', $workingHours['end']));
        
        while ($currentTime < $endTime) {
            $slotEnd = clone $currentTime;
            $slotEnd->add(new DateInterval('PT' . $duration . 'M'));
            
            // Check if this slot conflicts with any busy slots
            $isAvailable = true;
            foreach ($busySlots as $busySlot) {
                if ($this->slotsOverlap($currentTime, $slotEnd, $busySlot['start'], $busySlot['end'])) {
                    $isAvailable = false;
                    break;
                }
            }
            
            if ($isAvailable && $slotEnd <= $endTime) {
                $availableSlots[] = [
                    'start' => $currentTime->format('H:i'),
                    'end' => $slotEnd->format('H:i'),
                    'datetime' => $currentTime->format('Y-m-d H:i:s')
                ];
            }
            
            // Move to next 30-minute slot
            $currentTime->add(new DateInterval('PT30M'));
        }
        
        return $availableSlots;
    }
    
    /**
     * Check if two time slots overlap
     */
    private function slotsOverlap($start1, $end1, $start2, $end2) {
        return $start1 < $end2 && $start2 < $end1;
    }
    
    /**
     * Check if a specific time slot is available
     */
    public function isSlotAvailable($date, $startTime, $duration) {
        $slots = $this->getAvailableSlots($date, $duration);
        
        foreach ($slots as $slot) {
            if ($slot['start'] === $startTime) {
                return true;
            }
        }
        
        return false;
    }
}

// Helper function to get available slots (for use in booking.php)
function getAvailableTimeSlots($date, $duration = 60) {
    try {
        $calendarService = new GoogleCalendarService();
        return $calendarService->getAvailableSlots($date, $duration);
    } catch (Exception $e) {
        error_log('Error getting available slots: ' . $e->getMessage());
        // Fallback: return basic time slots if Google Calendar is not available
        return getBasicTimeSlots($date, $duration);
    }
}

// Fallback function for basic time slots
function getBasicTimeSlots($date, $duration = 60) {
    $slots = [];
    $startHour = 9;
    $endHour = 22;
    
    for ($hour = $startHour; $hour < $endHour; $hour++) {
        for ($minute = 0; $minute < 60; $minute += 30) {
            $slots[] = [
                'start' => sprintf('%02d:%02d', $hour, $minute),
                'end' => sprintf('%02d:%02d', $hour + ($minute + $duration >= 60 ? 1 : 0), ($minute + $duration) % 60),
                'datetime' => $date . ' ' . sprintf('%02d:%02d:00', $hour, $minute)
            ];
        }
    }
    
    return $slots;
}
?>