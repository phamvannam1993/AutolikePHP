@php
    $currentRouteName = \Illuminate\Support\Facades\Route::currentRouteName();
@endphp
<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="/" class="site_title">
                <i class="fa fa-thumbs-o-up"></i>
                <span> Autolike Manager</span>
            </a>
        </div>
        <div class="clearfix"></div>
        <div class="profile clearfix"><!--img_2 -->
            <div class="profile_pic">
                <img src="{{ config('app.asset_url') }}/images/circled-user-male-skin-type-1-2.png" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Xin chào admin, </span>
                <h2>Admin</h2>
            </div>
        </div>
        <br>
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section active">
                <h3>Chức năng</h3>
                <ul class="nav side-menu">
                    <li>
                        <a href="{{ route('website.home.index') }}"><i class="fa fa-home"></i> Trang chủ </a>
                    </li>
                    <li>
                        <a>
                            <i class="fa fa-table"></i>Quản lý thành viên <span class="fa fa-user-plus"></span>
                        </a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('website.agency.index') }}">Danh sách cộng tác viên</a></li>
                            <li><a href="{{ route('website.user.index') }}">Danh sách người dùng</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('website.transaction.index') }}"><i class="fa fa-money"></i> Quản lý nạp tiền </a>
                    </li>
                    <li>
                        <a href="{{ route('website.service.index') }}"><i class="fa fa-xing"></i> Dịch vụ viplike </a>
                    </li>

                    <li>
                        <a href="{{ route('website.service.indexType', ['type' => 'likepage']) }}"><i class="fa fa-xing"></i> Dịch vụ LikePage</a>
                    </li>

                    <li>
                        <a href="{{ route('website.service.indexType', ['type' => 'addfriend']) }}"><i class="fa fa-xing"></i> Dịch vụ Sub</a>
                    </li>

                    <li>
                        <a href="{{ route('website.fb-bot.index') }}"><i class="fa fa-magic"></i> Quản lý FB Token </a>
                    </li>
                    <li>
                        <a>
                            <i class="fa fa-table"></i> Gift code <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('website.gift-code.index') }}">Danh sách</a></li>
                            <li><a href="{{ route('website.gift-code.history') }}">Lịch sử sử dụng</a></li>
                            <li><a href="{{ route('website.gift-code.create') }}">Tạo mới gift code</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('website.import.formImport') }}"><i class="fa fa-upload"></i> Form Import </a>
                    </li>
                    <li>
                        <a href="{{ route('website.setting.edit') }}"><i class="fa fa-wrench"></i> Cấu hình hệ thống </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.fee.list') }}"><i class="fa fa-wrench"></i> Cấu hình khuyến mãi </a>
                    </li>
					<li>
						<a href="{{route('admin.package.list')}}"><i class="fa fa-gift"></i>Gói sử dụng</a>
					</li>
                    <li>
                        <a href="{{ route('admin.log') }}"><i class="fa fa-wrench"></i> log viplike </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>