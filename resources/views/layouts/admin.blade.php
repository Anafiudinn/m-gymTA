<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN KASIR - SIM UB GYM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        :root {
            --sidebar-bg: #0f1623;
            --sidebar-hover: #1a2236;
            --sidebar-active: #1e3a5f;
            --accent: #4f8ef7;
            --accent-glow: rgba(79,142,247,0.15);
        }
        /* Sidebar */
        #sidebar { background: var(--sidebar-bg); transition: transform 0.3s cubic-bezier(.4,0,.2,1); }
        .nav-item {
            display:flex; align-items:center; padding:9px 20px; border-radius:10px;
            margin:2px 10px; color:#a0aec0; font-size:13.5px; font-weight:500;
            transition:background 0.18s,color 0.18s,box-shadow 0.18s;
            position:relative; cursor:pointer; text-decoration:none;
        }
        .nav-item i { width:18px; margin-right:11px; font-size:13px; text-align:center; flex-shrink:0; }
        .nav-item:hover { background:var(--sidebar-hover); color:#e2e8f0; }
        .nav-item.active { background:var(--sidebar-active); color:#fff; box-shadow:0 2px 12px var(--accent-glow); }
        .nav-item.active i { color:var(--accent); }
        .nav-item.active::before {
            content:''; position:absolute; left:0; top:50%; transform:translateY(-50%);
            width:3px; height:60%; background:var(--accent); border-radius:0 3px 3px 0;
        }
        .nav-section-label {
            padding:14px 20px 4px; font-size:9.5px; font-weight:700;
            letter-spacing:.12em; color:#3d4f6e; text-transform:uppercase;
        }
        #sidebar-nav::-webkit-scrollbar { width:3px; }
        #sidebar-nav::-webkit-scrollbar-thumb { background:#243050; border-radius:4px; }

        /* Header */
        #main-header { background:#fff; border-bottom:1px solid #f0f4f9; box-shadow:0 1px 8px rgba(0,0,0,.05); }
        .search-bar {
            background:#f4f7fb; border-radius:10px; border:1.5px solid transparent;
            transition:border-color .2s,background .2s;
        }
        .search-bar:focus-within { border-color:var(--accent); background:#fff; }
        .icon-btn {
            width:36px; height:36px; border-radius:9px;
            display:flex; align-items:center; justify-content:center;
            background:#f4f7fb; color:#64748b; transition:background .15s,color .15s; cursor:pointer;
        }
        .icon-btn:hover { background:#e8effa; color:var(--accent); }
        .badge {
            position:absolute; top:-4px; right:-4px; width:16px; height:16px;
            border-radius:50%; background:#f43f5e; color:#fff; font-size:9px; font-weight:700;
            display:flex; align-items:center; justify-content:center; border:2px solid #fff;
        }

        /* Mobile */
        #sidebar-overlay {
            display:none; position:fixed; inset:0;
            background:rgba(0,0,0,.45); z-index:30; backdrop-filter:blur(2px);
        }
        #sidebar-overlay.active { display:block; }
        @media(max-width:767px) {
            #sidebar { position:fixed; top:0; left:0; bottom:0; z-index:40; transform:translateX(-100%); width:260px!important; }
            #sidebar.open { transform:translateX(0); }
        }

        /* Page fade */
        #main-content { animation:fadeUp .4s cubic-bezier(.4,0,.2,1) both; }
        @keyframes fadeUp { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:translateY(0)} }

        /* Flash alerts */
        .alert-success { background:linear-gradient(90deg,#ecfdf5,#d1fae5); border-left:4px solid #10b981; border-radius:10px; }
        .alert-error   { background:linear-gradient(90deg,#fff1f2,#ffe4e6); border-left:4px solid #f43f5e; border-radius:10px; }

        /* Scrollbar */
        #main-scroll::-webkit-scrollbar { width:5px; }
        #main-scroll::-webkit-scrollbar-track { background:#f4f7fb; }
        #main-scroll::-webkit-scrollbar-thumb { background:#d1daea; border-radius:6px; }

        /* ── Confirm Modal ── */
        #confirm-modal {
            position:fixed; inset:0; z-index:9999;
            display:flex; align-items:center; justify-content:center;
            opacity:0; pointer-events:none;
            transition:opacity .22s cubic-bezier(.4,0,.2,1);
        }
        #confirm-modal.show { opacity:1; pointer-events:all; }
        #confirm-modal .m-backdrop {
            position:absolute; inset:0;
            background:rgba(10,18,35,.58); backdrop-filter:blur(5px);
        }
        #confirm-modal .m-box {
            position:relative; z-index:1; background:#fff;
            border-radius:22px; padding:32px 28px 24px;
            width:90%; max-width:380px;
            box-shadow:0 30px 70px rgba(0,0,0,.2),0 0 0 1px rgba(0,0,0,.04);
            transform:scale(.92) translateY(16px);
            transition:transform .28s cubic-bezier(.34,1.56,.64,1);
            text-align:center;
        }
        #confirm-modal.show .m-box { transform:scale(1) translateY(0); }
        .m-icon {
            width:60px; height:60px; border-radius:18px;
            display:flex; align-items:center; justify-content:center;
            margin:0 auto 18px; font-size:24px;
        }
        .m-title { font-size:16px; font-weight:800; color:#1e293b; margin-bottom:7px; }
        .m-desc  { font-size:13px; color:#64748b; line-height:1.65; margin-bottom:26px; }
        .m-actions { display:flex; gap:10px; }
        .m-cancel {
            flex:1; padding:12px; border-radius:12px; background:#f1f5f9; color:#64748b;
            font-weight:700; font-size:13px; border:none; cursor:pointer; transition:background .15s;
        }
        .m-cancel:hover { background:#e2e8f0; }
        .m-ok {
            flex:1; padding:12px; border-radius:12px; color:#fff;
            font-weight:700; font-size:13px; border:none; cursor:pointer;
            transition:filter .15s,transform .1s;
        }
        .m-ok:hover  { filter:brightness(1.1); }
        .m-ok:active { transform:scale(.97); }
    </style>
</head>
<body class="bg-[#f5f7fb]">

<div class="flex h-screen overflow-hidden">

    <div id="sidebar-overlay" onclick="closeSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="w-[240px] flex-shrink-0 flex flex-col md:relative md:translate-x-0">
        <div class="flex items-center gap-3 px-5 py-5 border-b border-white/5">
            <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center shadow-lg shadow-blue-600/30">
                <i class="fa fa-dumbbell text-white text-xs"></i>
            </div>
            <div>
                <span class="text-white font-bold text-sm tracking-wide">UB GYM</span>
                <p class="text-[10px] text-[#3d5080] font-semibold uppercase tracking-widest leading-none mt-0.5">Kasir Panel</p>
            </div>
        </div>

        <nav id="sidebar-nav" class="flex-1 overflow-y-auto py-3">
            <a href="{{ route('admin.dashboard') }}"
               class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa fa-home"></i> Dashboard
            </a>

            <div class="nav-section-label">Kehadiran</div>
            <a href="{{ route('admin.attendance.index') }}"
               class="nav-item {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}">
                <i class="fa fa-qrcode"></i> Check-in
            </a>
            <a href="{{ route('admin.retail.index') }}"
               class="nav-item {{ request()->routeIs('admin.retail.*') ? 'active' : '' }}">
                <i class="fa fa-shopping-basket"></i> Kasir Retail
            </a>

            <div class="nav-section-label">Membership</div>
            <a href="{{ route('admin.package.index') }}"
               class="nav-item {{ request()->routeIs('admin.package.*') ? 'active' : '' }}">
                <i class="fa fa-id-card"></i> Beli Paket & Aktivasi
            </a>
            <a href="{{ route('admin.pt.index') }}"
               class="nav-item {{ request()->routeIs('admin.pt.*') ? 'active' : '' }}">
                <i class="fa fa-dumbbell"></i> Sesi PT
            </a>

            <div class="nav-section-label">Master Data</div>
            <a href="{{ route('admin.data.members') }}"
               class="nav-item {{ request()->routeIs('admin.data.members') ? 'active' : '' }}">
                <i class="fa fa-users"></i> Data Member
            </a>
            <a href="{{ route('admin.data.products') }}"
               class="nav-item {{ request()->routeIs('admin.data.products') ? 'active' : '' }}">
                <i class="fa fa-box"></i> Data Produk
            </a>

            <div class="nav-section-label">Laporan</div>
            <a href="{{ route('admin.report.transactions') }}"
               class="nav-item {{ request()->routeIs('admin.report.transactions') ? 'active' : '' }}">
                <i class="fa fa-file-invoice-dollar"></i> Riwayat Transaksi
            </a>
            <a href="{{ route('admin.report.attendance') }}"
               class="nav-item {{ request()->routeIs('admin.report.attendance') ? 'active' : '' }}">
                <i class="fa fa-calendar-check"></i> Riwayat Kehadiran
            </a>
        </nav>

        <!-- Logout with confirm -->
        <div class="p-3 border-t border-white/5">
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <button type="button"
                    data-confirm
                    data-confirm-title="Keluar dari Sistem?"
                    data-confirm-desc="Sesi kamu akan diakhiri. Pastikan semua transaksi sudah tersimpan sebelum keluar."
                    data-confirm-type="warning"
                    data-confirm-label="Ya, Keluar"
                    data-confirm-form="logout-form"
                    class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-[13px] font-semibold text-[#f87171] hover:bg-red-500/10 transition-all duration-200">
                    <div class="w-7 h-7 rounded-lg bg-red-500/10 flex items-center justify-center">
                        <i class="fa fa-sign-out-alt text-[11px] text-red-400"></i>
                    </div>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main -->
    <div class="flex-1 flex flex-col overflow-hidden min-w-0">
        <header id="main-header" class="h-[60px] flex items-center justify-between px-5 md:px-7 flex-shrink-0 z-20">
            <div class="flex items-center gap-3">
                <button class="md:hidden icon-btn" onclick="openSidebar()">
                    <i class="fa fa-bars text-sm"></i>
                </button>
                <div class="search-bar hidden sm:flex items-center gap-2 px-3 py-2 w-52 md:w-64">
                    <i class="fa fa-search text-[#94a3b8] text-xs"></i>
                    <input type="text" placeholder="Cari sesuatu..."
                        class="bg-transparent outline-none text-[13px] text-slate-700 placeholder-slate-400 w-full">
                </div>
            </div>
            <div class="flex items-center gap-2 md:gap-3">
                <div class="relative">
                    <div class="icon-btn"><i class="fa fa-bell text-sm"></i></div>
                    <span class="badge">3</span>
                </div>
                <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>
                <div class="flex items-center gap-2.5 cursor-pointer group">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-sm">
                        <i class="fa fa-user text-white text-xs"></i>
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-[13px] font-semibold text-slate-800 leading-tight">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-emerald-500 font-bold uppercase leading-tight">● Online</p>
                    </div>
                    <i class="fa fa-chevron-down text-[10px] text-slate-400 hidden sm:block group-hover:text-slate-600 transition-colors"></i>
                </div>
            </div>
        </header>

        <main id="main-scroll" class="flex-1 overflow-y-auto p-5 md:p-7">
            <div id="main-content">

                @if(session('success'))
                <div class="alert-success flex items-center gap-3 p-4 mb-5 shadow-sm" id="flash-ok">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center flex-shrink-0">
                        <i class="fa fa-check-circle text-emerald-600 text-sm"></i>
                    </div>
                    <p class="text-[13.5px] font-semibold text-emerald-800">{{ session('success') }}</p>
                    <button onclick="this.parentElement.remove()" class="ml-auto text-emerald-400 hover:text-emerald-600 transition-colors">
                        <i class="fa fa-times text-xs"></i>
                    </button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert-error flex items-center gap-3 p-4 mb-5 shadow-sm" id="flash-err">
                    <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                        <i class="fa fa-times-circle text-red-500 text-sm"></i>
                    </div>
                    <p class="text-[13.5px] font-semibold text-red-700">{{ session('error') }}</p>
                    <button onclick="this.parentElement.remove()" class="ml-auto text-red-300 hover:text-red-500 transition-colors">
                        <i class="fa fa-times text-xs"></i>
                    </button>
                </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</div>

<!-- ── Confirm Modal ── -->
<div id="confirm-modal">
    <div class="m-backdrop" onclick="UBConfirm.cancel()"></div>
    <div class="m-box">
        <div class="m-icon" id="m-icon-wrap"><i id="m-icon" class="fa fa-question"></i></div>
        <div class="m-title" id="m-title">Konfirmasi Aksi</div>
        <div class="m-desc"  id="m-desc">Apakah kamu yakin ingin melanjutkan?</div>
        <div class="m-actions">
            <button class="m-cancel" onclick="UBConfirm.cancel()">Batal</button>
            <button class="m-ok"     id="m-ok" onclick="UBConfirm.proceed()">Ya, Lanjutkan</button>
        </div>
    </div>
</div>

<script>
/* ── Sidebar ── */
function openSidebar(){
    document.getElementById('sidebar').classList.add('open');
    document.getElementById('sidebar-overlay').classList.add('active');
    document.body.style.overflow='hidden';
}
function closeSidebar(){
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sidebar-overlay').classList.remove('active');
    document.body.style.overflow='';
}

/* ── Flash dismiss ── */
['flash-ok','flash-err'].forEach(id=>{
    const el=document.getElementById(id);
    if(!el)return;
    setTimeout(()=>{
        el.style.transition='opacity .4s,transform .4s';
        el.style.opacity='0'; el.style.transform='translateY(-8px)';
        setTimeout(()=>el.remove(),420);
    },4500);
});

/* ── ESC ── */
document.addEventListener('keydown',e=>{
    if(e.key==='Escape'){ closeSidebar(); UBConfirm.cancel(); }
});

/* ═══════════════════════════════════════════════
   UBConfirm — Global Confirm Modal Engine
   ───────────────────────────────────────────────
   CARA PAKAI (attribute — paling gampang):

   Pada tombol submit:
   <button type="submit"
       data-confirm
       data-confirm-title="Catat Kehadiran Tamu?"
       data-confirm-desc="Pastikan nama dan pembayaran sudah benar."
       data-confirm-type="info"
       data-confirm-label="Ya, Catat">
       Simpan
   </button>

   Pada link:
   <a href="/hapus/1"
       data-confirm
       data-confirm-title="Hapus Data?"
       data-confirm-type="danger"
       data-confirm-label="Hapus">Hapus</a>

   type: "danger" | "warning" | "info" | "success"

   CARA PAKAI (programmatic / Promise):
   UBConfirm.ask({
       title : 'Judul Modal',
       desc  : 'Deskripsi aksi ini.',
       type  : 'danger',
       label : 'Ya, Hapus'
   }).then(ok => { if(ok) doSomething(); });
═══════════════════════════════════════════════ */
const UBConfirm=(()=>{
    const modal   =document.getElementById('confirm-modal');
    const iconWrap=document.getElementById('m-icon-wrap');
    const iconEl  =document.getElementById('m-icon');
    const titleEl =document.getElementById('m-title');
    const descEl  =document.getElementById('m-desc');
    const btnOk   =document.getElementById('m-ok');

    const T={
        danger : {bg:'#fef2f2',col:'#ef4444',btn:'#ef4444',ic:'fa-exclamation-triangle'},
        warning: {bg:'#fffbeb',col:'#f59e0b',btn:'#f59e0b',ic:'fa-exclamation-circle'},
        info   : {bg:'#eff6ff',col:'#3b82f6',btn:'#3b82f6',ic:'fa-info-circle'},
        success: {bg:'#f0fdf4',col:'#10b981',btn:'#10b981',ic:'fa-check-circle'},
    };

    let _resolve=null, _form=null, _href=null;

    function _theme(type){
        const t=T[type]||T.danger;
        iconWrap.style.background=t.bg;
        iconEl.style.color=t.col;
        iconEl.className='fa '+t.ic;
        btnOk.style.background=t.btn;
    }

    function open(opts={}){
        _theme(opts.type||'danger');
        titleEl.textContent=opts.title||'Konfirmasi Aksi';
        descEl.textContent =opts.desc ||'Apakah kamu yakin ingin melanjutkan?';
        btnOk.textContent  =opts.label||'Ya, Lanjutkan';
        modal.classList.add('show');
    }

    function cancel(){
        modal.classList.remove('show');
        _form=null; _href=null;
        if(_resolve){_resolve(false);_resolve=null;}
    }

    function proceed(){
        modal.classList.remove('show');
        if(_form){_form.submit();_form=null;return;}
        if(_href){window.location.href=_href;_href=null;return;}
        if(_resolve){_resolve(true);_resolve=null;}
    }

    function ask(opts){
        return new Promise(res=>{_resolve=res;open(opts);});
    }

    /* Auto-bind [data-confirm] clicks */
    document.addEventListener('click',e=>{
        const el=e.target.closest('[data-confirm]');
        if(!el)return;
        e.preventDefault(); e.stopPropagation();

        const opts={
            title : el.dataset.confirmTitle ||'Konfirmasi Aksi',
            desc  : el.dataset.confirmDesc  ||'Apakah kamu yakin ingin melanjutkan?',
            type  : el.dataset.confirmType  ||'danger',
            label : el.dataset.confirmLabel ||'Ya, Lanjutkan',
        };

        /* resolve target */
        if(el.tagName==='A'){
            _href=el.href;
        } else {
            /* support data-confirm-form="form-id" atau closest form */
            const formId=el.dataset.confirmForm;
            _form=formId ? document.getElementById(formId) : el.closest('form');
        }
        open(opts);
    },true);

    return{open,cancel,proceed,ask};
})();
</script>

@stack('scripts')
</body>
</html>