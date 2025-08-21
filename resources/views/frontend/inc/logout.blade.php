<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Siap untuk Pergi?</h5>
            <button class="close border-0" type="button" data-bs-dismiss="modal" aria-label="Close">
                <span class="h3">×</span>
            </button>
        </div>
        <div class="modal-body">Pilih "Keluar" di bawah jika Anda siap mengakhiri sesi Anda saat ini.</div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
            <form action="/logout" method="post">
                @csrf
                <button class="btn btn-primary">Logout</button>
            </form>
            {{-- <a class="btn btn-primary" href="/logout">Logout</a> --}}
        </div>
    </div>
</div>
</div>
