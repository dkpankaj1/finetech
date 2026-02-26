<!-- Confirm Delete Modal -->
<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $modalId }}Label">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    {{ $title }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">{{ $message }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>
                    {{ $cancelText }}
                </button>
                <form id="{{ $modalId }}Form" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-{{ $confirmVariant }}">
                        <i class="fas fa-trash me-1"></i>
                        {{ $confirmText }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('{{ $modalId }}');
            const form = document.getElementById('{{ $modalId }}Form');

            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const deleteUrl = button.getAttribute('data-delete-url');
                const itemName = button.getAttribute('data-item-name');

                if (deleteUrl) {
                    form.setAttribute('action', deleteUrl);
                }

                if (itemName) {
                    const messageElement = modal.querySelector('.modal-body p');
                    messageElement.textContent = `Are you sure you want to delete "${itemName}"? This action cannot be undone.`;
                }
            });
        });
    </script>
@endpush