<div class="dashboard-topbar">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="topbar-left">
                        <div class="open-menu d-inline-flex d-xl-none">
                            <i class="ri-menu-unfold-4-line"></i>
                        </div>
                        <h2 class="topbar-title">
                            @yield('title')
                        </h2>
                    </div>

                    <div class="topbar-right">
                        <div class="account-info">
                            <div class="current">AD</div>
                            <div class="sub-menu">
                                <div class="welcome-info">
                                    <h6>JOHAN OSORIO</h6>
                                    <p>admin@gmail.com</p>
                                </div>
                                <div class="separator"></div>
                                <ul>
                                    <li>
                                        <a href="#">
                                            <i class="ri-user-line"></i> Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="ri-settings-3-line"></i> Settings
                                        </a>
                                    </li>
                                </ul>
                                <div class="separator"></div>
                                <div class="logout-wrap">
                                    <form action="#" method="POST">
                                        <button type="submit" class="logout">
                                            <i class="ri-logout-box-r-line"></i> Sign out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
