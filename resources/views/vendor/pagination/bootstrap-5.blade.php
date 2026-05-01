<style>
    /* Pagination Container */
    .pagination {
        margin-bottom: 0;
        gap: 4px; /* Kasih jarak antar kotak biar industrial look */
    }

    /* Kotak Angka Standar */
    .page-link {
        color: #475569; /* Slate 600 */
        border: 1px solid #e2e8f0;
        border-radius: 6px !important;
        padding: 0.5rem 0.85rem;
        transition: all 0.2s ease;
        font-weight: 500;
        background-color: transparent;
    }

    /* Hover State */
    .page-link:hover {
        background-color: rgba(16, 185, 129, 0.08);
        border-color: #10b981;
        color: #10b981;
        z-index: 2;
    }

    /* Active State (Angka yang sedang dibuka) */
    .page-item.active .page-link {
        background-color: #10b981 !important; /* Emerald */
        border-color: #10b981 !important;
        color: #fff !important;
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.25);
    }

    /* Disabled State (Tanda panah mati) */
    .page-item.disabled .page-link {
        background-color: transparent;
        color: #cbd5e1;
        border-color: #f1f5f9;
    }

    /* Teks "Showing x to y of z" */
    p.small.text-muted {
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
    }
    
    p.small.text-muted .fw-semibold {
        color: #10b981; /* Bikin angkanya ijo biar fokus */
    }
</style>