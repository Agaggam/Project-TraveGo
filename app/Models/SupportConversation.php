<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupportConversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject',
        'status',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    /**
     * Get the user that owns the conversation
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all messages in this conversation
     */
    public function messages(): HasMany
    {
        return $this->hasMany(SupportMessage::class, 'conversation_id');
    }

    /**
     * Get the latest message
     */
    public function latestMessage()
    {
        return $this->hasOne(SupportMessage::class, 'conversation_id')->latestOfMany();
    }

    /**
     * Get unread messages count for a specific user type
     */
    public function unreadCountFor(string $userType): int
    {
        $oppositeType = $userType === 'user' ? 'admin' : 'user';
        return $this->messages()
            ->where('sender_type', $oppositeType)
            ->where('is_read', false)
            ->count();
    }

    /**
     * Scope for open conversations
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    /**
     * Scope for closed conversations
     */
    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    /**
     * Check if conversation is open
     */
    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    /**
     * Close the conversation
     */
    public function close(): void
    {
        $this->update(['status' => 'closed']);
    }

    /**
     * Reopen the conversation
     */
    public function reopen(): void
    {
        $this->update(['status' => 'open']);
    }
}
