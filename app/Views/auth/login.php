<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Kinerja FMIPA USK</title>
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <script src="<?= base_url('js/app.js') ?>"></script>
    <script>
        const BASE_URL = "<?= base_url() ?>"
    </script>
</head>

<body>
    <div class="container mx-auto px-4 mt-32">
        <div id="brand-wrapper" class="lg:mb-0 lg:py-2 max-w-md w-full mx-auto">
            <img src="<?= base_url('images/logo.png') ?>" class="mx-auto" alt="logo" width="300">
        </div>

        <div class="max-w-md lg:m-auto w-full mx-auto">

            <form id="form-login" method="POST" action="<?= base_url('auth/login') ?>">
                <div class="form-control">
                    <label for="username" class="label">
                        <span class="label-text">Username</span>
                    </label>
                    <input type="text" name="username" id="username" class="input input-bordered" autofocus>
                </div>

                <div class="form-control">
                    <label for="password" class="label">
                        <span class="label-text">Password</span>
                    </label>
                    <input type="password" name="password" id="password" class="input input-bordered">
                </div>

                <button type="submit" class="btn btn-primary btn-block font-bold mt-6">MASUK</button>
            </form>

            <!-- Footer -->
            <footer class="footer footer-center p-4 ">
                <div>
                    <p>Copyright © <?= date('Y') ?> - All right reserved by FMIPA USK</p>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
    </div>

    <script>
        initFormAjax('#form-login', {
            success: function(response) {
                toastr.success(response.message)
                setTimeout(function() {
                    location.href = `${BASE_URL}`
                }, 1500);
            },
            error: function(xhr) {
                const response = xhr.responseJSON
                toastr.error(response.message)
            }
        })
    </script>
</body>

</html>