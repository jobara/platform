<?php

namespace App\View\Components\Notification;

use App\Models\Project;
use App\View\Components\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Notifications\DatabaseNotification;

class EstimateReturned extends Notification
{
    public Project $project;

    public function __construct(DatabaseNotification $notification)
    {
        $this->project = Project::find($notification->data['project_id']);
        $this->title = __('Engagement estimate has been submitted for your approval');
        $this->body = safe_markdown('Your estimate for **:project**, along with a project agreement for you to sign, has been sent to <:contact>.', [
            'project' => $this->project->getTranslation('name', locale()),
            'contact' => $this->project->contact_person_email,
        ]);
        $this->interpretation = __('Engagement estimate has been submitted for your approval', [], 'en');

        parent::__construct($notification);
    }

    public function render(): View
    {
        return view('components.notification.estimate-returned', [
            'notification' => $this->notification,
            'read' => ! is_null($this->notification->read_at),
            'title' => $this->title,
            'body' => $this->body,
            'project' => $this->project,
            'interpretation' => $this->interpretation,
        ]);
    }
}
