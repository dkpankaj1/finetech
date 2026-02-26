<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ConfirmDeleteModel extends Component
{
    public string $modalId;
    public string $title;
    public string $message;
    public string $confirmText;
    public string $cancelText;
    public string $confirmVariant;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $modalId = 'confirmDeleteModal',
        string $title = 'Confirm Delete',
        string $message = 'Are you sure you want to delete this item? This action cannot be undone.',
        string $confirmText = 'Delete',
        string $cancelText = 'Cancel',
        string $confirmVariant = 'danger'
    ) {
        $this->modalId = $modalId;
        $this->title = $title;
        $this->message = $message;
        $this->confirmText = $confirmText;
        $this->cancelText = $cancelText;
        $this->confirmVariant = $confirmVariant;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.confirm-delete-model');
    }
}
