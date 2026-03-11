<div data-simplebar>
    <ul class="app-menu">

        <!-- Dashboard -->
        <li class="menu-item">
            <a href="{{ route('finetech.dashboard') }}" class="menu-link waves-effect">
                <span class="menu-icon"><i data-lucide="layout-grid"></i></span>
                <span class="menu-text">Dashboard</span>
            </a>
        </li>



        <!-- FDS -->
        <li class="menu-item">
            <a href="#menuFDS" data-bs-toggle="collapse" class="menu-link waves-effect">
                <span class="menu-icon"><i data-lucide="box"></i></span>
                <span class="menu-text">FDS</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="menuFDS">
                <ul class="sub-menu">
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <span class="menu-text">View FDS</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <span class="menu-text">Create FDS</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Deposits -->
        <li class="menu-item">
            <a href="#menuDeposits" data-bs-toggle="collapse" class="menu-link waves-effect">
                <span class="menu-icon"><i data-lucide="wallet"></i></span>
                <span class="menu-text">Deposits</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="menuDeposits">
                <ul class="sub-menu">
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <span class="menu-text">View Deposits</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <span class="menu-text">New Deposit</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Withdrawals -->
        <li class="menu-item">
            <a href="#menuWithdrawals" data-bs-toggle="collapse" class="menu-link waves-effect">
                <span class="menu-icon"><i data-lucide="arrow-up-right"></i></span>
                <span class="menu-text">Withdrawals</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="menuWithdrawals">
                <ul class="sub-menu">
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <span class="menu-text">View Withdrawals</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <span class="menu-text">New Withdrawal</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Transactions -->
        <li class="menu-item">
            <a href="#" class="menu-link waves-effect">
                <span class="menu-icon"><i data-lucide="file-clock"></i></span>
                <span class="menu-text">Transactions</span>
            </a>
        </li>

        <!-- Document Service -->
        <li class="menu-title">Customers And Accounts</li>

        <!-- Customers -->
        <li class="menu-item">
            <a href="#menuAccountMgr" data-bs-toggle="collapse" class="menu-link waves-effect">
                <span class="menu-icon"><i data-lucide="square-user"></i></span>
                <span class="menu-text">Account Manager</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="menuAccountMgr">
                <ul class="sub-menu">
                    <li class="menu-item">
                        <a href="{{ route('finetech.accounts.index') }}" class="menu-link">
                            <span class="menu-text">All Account</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('finetech.accounts.create') }}" class="menu-link">
                            <span class="menu-text">Open Account</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <span class="menu-text">Search Account</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        
        <!-- Customers -->
        <li class="menu-item">
            <a href="#menuUser" data-bs-toggle="collapse" class="menu-link waves-effect">
                <span class="menu-icon"><i data-lucide="users"></i></span>
                <span class="menu-text">Customers</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="menuUser">
                <ul class="sub-menu">
                    <li class="menu-item">
                        <a href="{{ route('finetech.customers.index') }}" class="menu-link">
                            <span class="menu-text">List All</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('finetech.customers.create') }}" class="menu-link">
                            <span class="menu-text">Create User</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <span class="menu-text">Search User</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Withdrawals -->
        <li class="menu-item">
            <a href="#menuKyc" data-bs-toggle="collapse" class="menu-link waves-effect">
                <span class="menu-icon"><i data-lucide="shield-check"></i></span>
                <span class="menu-text">Kyc</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="menuKyc">
                <ul class="sub-menu">
                    <li class="menu-item">
                        <a href="{{ route('finetech.kyc-documents.index') }}" class="menu-link">
                            <span class="menu-text">View All</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('finetech.kyc-documents.create') }}" class="menu-link">
                            <span class="menu-text">New Kyc</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>


        <!-- Masters -->
        <li class="menu-title">Masters</li>

        <!-- AccountType Masters -->
        <li class="menu-item">
            <a href="#menuAccountType" data-bs-toggle="collapse" class="menu-link waves-effect">
                <span class="menu-icon"><i data-lucide="sliders-vertical"></i></span>
                <span class="menu-text">AccountType Masters</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="menuAccountType">
                <ul class="sub-menu">
                    <li class="menu-item">
                        <a href="{{ route('finetech.account-types.index') }}" class="menu-link">
                            <span class="menu-text">List All</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('finetech.account-types.create') }}" class="menu-link">
                            <span class="menu-text">Add New</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Branches Masters-->
        <li class="menu-item">
            <a href="#menuBranches" data-bs-toggle="collapse" class="menu-link waves-effect">
                <span class="menu-icon"><i data-lucide="git-branch"></i></span>
                <span class="menu-text">Branches Masters</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="menuBranches">
                <ul class="sub-menu">
                    <li class="menu-item">
                        <a href="{{ route('finetech.branches.index') }}" class="menu-link">
                            <span class="menu-text">Branch List</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('finetech.branches.create') }}" class="menu-link">
                            <span class="menu-text">Add New Branch</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <!-- Currency Masters-->
        <li class="menu-item">
            <a href="#menuMaster" data-bs-toggle="collapse" class="menu-link waves-effect">
                <span class="menu-icon"><i data-lucide="sliders-vertical"></i></span>
                <span class="menu-text">Currency Masters</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="menuMaster">
                <ul class="sub-menu">
                    <li class="menu-item">
                        <a href="{{ route('finetech.currencies.index') }}" class="menu-link">
                            <span class="menu-text">Currency List</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('finetech.currencies.create') }}" class="menu-link">
                            <span class="menu-text">Add Currency</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="menu-title">User Management</li>

        <!-- Users -->
        <li class="menu-item">
            <a href="#menuUserMgr" data-bs-toggle="collapse" class="menu-link waves-effect">
                <span class="menu-icon"><i data-lucide="user"></i></span>
                <span class="menu-text">User Manager</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="menuUserMgr">
                <ul class="sub-menu">
                    <li class="menu-item">
                        <a href="{{ route('finetech.users.index') }}" class="menu-link">
                            <span class="menu-text">User List</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('finetech.users.create') }}" class="menu-link">
                            <span class="menu-text">Create User</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('finetech.authorization.index') }}" class="menu-link">
                            <span class="menu-text">Role & Permission</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="menu-title">Profile & Settings</li>
        <!-- Settings -->
        <li class="menu-item">
            <a href="#menuSetting" data-bs-toggle="collapse" class="menu-link waves-effect">
                <span class="menu-icon"><i data-lucide="settings"></i></span>
                <span class="menu-text">Settings</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="menuSetting">
                <ul class="sub-menu">
                    <li class="menu-item">
                        <a href="{{ route('finetech.settings.edit') }}" class="menu-link">
                            <span class="menu-text">General Settings</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- My Profile -->
        <li class="menu-item">
            <a href="#menuProfile" data-bs-toggle="collapse" class="menu-link waves-effect">
                <span class="menu-icon"><i data-lucide="user"></i></span>
                <span class="menu-text">My Profile</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="menuProfile">
                <ul class="sub-menu">
                    <li class="menu-item">
                        <a href="{{ route('finetech.profile.index') }}" class="menu-link">
                            <span class="menu-text">My Account</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('finetech.profile.update') }}" class="menu-link">
                            <span class="menu-text">Update Profile</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('finetech.profile.password') }}" class="menu-link">
                            <span class="menu-text">Change Password</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

    </ul>
</div>