<div id="sidebar-nav" class="sidebar">
    <div class="sidebar-scroll">
        <nav>
            <ul class="nav">
                <li><a href="{{ route('dashboard.admin') }}" class="active"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
                <li>
                    <a href="#subPages" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>Master Data</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                    <div id="subPages" class="collapse ">
                        <ul class="nav">
                            <li><a href="{{ route('dashboard.admin.vendor') }}" class="active"><i class="lnr lnr-store"></i> <span>Vendor</span></a></li>
                            <li><a href="{{ route('item') }}" class="active"><i class="lnr lnr-home"></i> <span>Seluruh Barang</span></a></li>
                        </ul>
                    </div>
                </li>
                <li><a href="{{ route('incoming.item.index') }}"><i class="lnr lnr-enter-down"></i> <span>Barang Masuk</span></a></li>
                <li><a href="{{ route('itemout') }}"><i class="lnr lnr-exit-up"></i> <span>Barang Keluar</span></a></li>
                <li><a href="{{ route('stock') }}"><i class="lnr lnr-store"></i> <span>Stok</span></a></li>
                <li><a href="{{ route('report') }}"><i class="lnr lnr-book"></i> <span>Laporan</span></a></li>
                <li><a href="{{ route('logout') }}"><i class="lnr lnr-exit"></i> <span>Keluar</span></a></li>
            </ul>
        </nav>
    </div>
</div>