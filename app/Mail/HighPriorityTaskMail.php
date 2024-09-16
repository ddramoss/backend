<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HighPriorityTaskMail extends Mailable
{
    use Queueable, SerializesModels;

    public $task;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($task, $user)
    {
        $this->task = $task;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Tarea de alta prioridad: ' . $this->task->title)
                    ->view('emails.high_priority_task')
                    ->with([
                        'taskTitle' => $this->task->title,
                        'taskDescription' => $this->task->description,
                        'dueDate' => $this->task->due_date,
                        'userName' => $this->user->name,
                    ]);
    }
}
