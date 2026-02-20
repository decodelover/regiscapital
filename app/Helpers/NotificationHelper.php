<?php

namespace App\Helpers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Throwable;

class NotificationHelper
{
    /**
     * Create a new notification for a user.
     *
     * @param  User|int  $user  The user or user ID
     * @param  string  $message  Notification message
     * @param  string|null  $title  Notification title
     * @param  string  $type  Notification type (info, success, warning, danger)
     * @param  string|null  $icon  Lucide icon name
     * @param  string|null  $link  URL to redirect when clicked
     * @param  array|null  $data  Additional data
     * @return Notification|null
     */
    public static function create($user, $message, $title = null, $type = 'info', $icon = null, $link = null, $data = null)
    {
        $userId = $user instanceof User ? $user->id : $user;
        
        // Set default icon based on type if not provided
        if ($icon === null) {
            $icon = self::getDefaultIconForType($type);
        }
        
        try {
            return Notification::create([
                'user_id' => $userId,
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'icon' => $icon,
                'link' => $link,
                'data' => $data,
                'is_read' => false,
            ]);
        } catch (QueryException $e) {
            Log::error('NotificationHelper: Database error creating notification', [
                'user' => $userId,
                'title' => $title,
                'type' => $type,
                'error' => $e->getMessage(),
            ]);
            return null;
        } catch (Throwable $e) {
            Log::error('NotificationHelper: Unexpected error creating notification', [
                'user' => $userId,
                'title' => $title,
                'type' => $type,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }
    
    /**
     * Create a notification with retry logic for database issues.
     *
     * @param  User|int  $user  The user or user ID
     * @param  string  $message  Notification message
     * @param  string|null  $title  Notification title
     * @param  string  $type  Notification type
     * @param  string|null  $icon  Lucide icon name
     * @param  string|null  $link  URL to redirect when clicked
     * @param  array|null  $data  Additional data
     * @param  int  $maxRetries  Maximum number of retry attempts
     * @return Notification|null
     */
    public static function createSafe($user, $message, $title = null, $type = 'info', $icon = null, $link = null, $data = null, $maxRetries = 2)
    {
        $attempts = 0;
        
        while ($attempts <= $maxRetries) {
            $notification = self::create($user, $message, $title, $type, $icon, $link, $data);
            
            if ($notification !== null) {
                return $notification;
            }
            
            $attempts++;
            
            if ($attempts <= $maxRetries) {
                Log::info("NotificationHelper: Retrying notification creation (attempt {$attempts}/{$maxRetries})");
                usleep(100000); // Wait 100ms before retry
            }
        }
        
        Log::error('NotificationHelper: Failed to create notification after all retry attempts', [
            'user' => $user instanceof User ? $user->id : $user,
            'message' => $message,
            'max_retries' => $maxRetries
        ]);
        
        return null;
    }
    
    /**
     * Get the default icon for a notification type.
     *
     * @param  string  $type
     * @return string
     */
    private static function getDefaultIconForType($type)
    {
        switch ($type) {
            case 'success':
                return 'check-circle';
            case 'warning':
                return 'alert-triangle';
            case 'danger':
                return 'alert-circle';
            case 'info':
            default:
                return 'info';
        }
    }
}