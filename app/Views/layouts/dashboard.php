<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <script src="<?= base_url('js/app.js') ?>"></script>
    <script>
        const BASE_URL = "<?= base_url() ?>"
    </script>
    <?= $this->renderSection('page-assets') ?>
</head>

<body>
    <div class="lg:mx-4">
        <div class="drawer drawer-mobile">
            <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content">
                <!-- Page content here -->

                <!-- Navbar -->
                <div class="navbar bg-base-100">
                    <div class="flex-1">
                        <label for="my-drawer-2" class="drawer-button lg:hidden px-3 pt-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </label>
                    </div>
                    <div class="flex-none gap-2">
                        <div class="pt-3 font-semibold">Admin FMIPA</div>
                        <div class="dropdown dropdown-end">
                            <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                                <div class="w-15 rounded-full">
                                    <img src="<?= base_url('images/profile.png') ?>" />
                                </div>
                            </label>
                            <ul tabindex="0" class="mt-3 p-2 shadow menu menu-compact dropdown-content bg-base-100 rounded-box w-52">
                                <li>
                                    <a href="#">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- End of Navbar -->

                <!-- Content -->
                <div class="mx-5 pt-5">
                    <?= $this->renderSection('content') ?>
                </div>
                <!-- End Of Content -->

                <!-- Footer -->
                <footer class="footer footer-center p-4 ">
                    <div>
                        <p>Copyright © <?= date('Y') ?> - All right reserved by FMIPA USK</p>
                    </div>
                </footer>
                <!-- End of Footer -->

            </div>
            <div class="drawer-side">
                <label for="my-drawer-2" class="drawer-overlay"></label>
                <ul class="menu p-4 w-64 bg-base-100 text-base-content">
                    <!-- Sidebar content here -->
                    <img src="<?= base_url('images/logo.png') ?>" alt="Logo" width="200" class="mx-auto">
                    <hr class="my-5">
                    <li class="<?= strpos(current_url(), 'beranda') ? 'active' : '' ?>">
                        <a class="flex justify-between" href="<?= base_url('beranda') ?>">
                            <div class="flex justify-start">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                <span class="pl-2">Beranda</span>
                            </div>

                            <div>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </a>
                    </li>

                    <li class="<?= strpos(current_url(), 'capaian') ? 'active' : '' ?>">
                        <a class="flex justify-between" href="<?= base_url('capaian') ?>">
                            <div class="flex justify-start">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H5zm-1 9v-1h5v2H5a1 1 0 01-1-1zm7 1h4a1 1 0 001-1v-1h-5v2zm0-4h5V8h-5v2zM9 8H4v2h5V8z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="pl-2">Capaian</span>
                            </div>

                            <div>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </a>
                    </li>

                    <li class="<?= strpos(current_url(), 'indikatorKinerja') ? 'active' : '' ?>">
                        <a class="flex justify-between" href="<?= base_url('indikatorKinerja') ?>">
                            <div class="flex justify-start">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H5zm-1 9v-1h5v2H5a1 1 0 01-1-1zm7 1h4a1 1 0 001-1v-1h-5v2zm0-4h5V8h-5v2zM9 8H4v2h5V8z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="pl-2">Indikator Kinerja</span>
                            </div>

                            <div>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <input type="checkbox" id="modal-global" class="modal-toggle" />
    <label id="modal-global-container" for="modal-global" class="modal modal-bottom sm:modal-middle cursor-pointer">
        <label class="modal-box p-8 relative">

        </label>
    </label>


</body>

</html>