<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Poliklinik</title>
    <link href="./dist/css/stylesku.css" rel="stylesheet" />
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="#">Poliklinik</a>
            <?php if ($muncul) : ?>
                <div class="navbar-links">
                    <a class="nav-link" href="http://<?= $_SERVER['HTTP_HOST'] ?>/poliklinik/pages/<?= $arah ?>">Dashboard</a>
                </div>
            <?php endif ?>
        </div>
    </nav>

    <?php if (!$muncul) : ?>
        <section class="features" id="features">
            <div class="container">
                <div class="feature-item">
                    <h2 class="feature-title">Registrasi Sebagai Pasien</h2>
                    <p>Apabila Anda adalah seorang Pasien, silahkan Registrasi terlebih dahulu untuk melakukan pendaftaran sebagai Pasien!</p>
                    <a class="feature-link" href="http://<?= $_SERVER['HTTP_HOST'] ?>/poliklinik/pages/auth/register.php">
                        Klik Link Berikut <i class="icon-arrow-right"></i>
                    </a>
                </div>
                <div class="feature-item">
                    <h2 class="feature-title">Login Sebagai Dokter</h2>
                    <p>Apabila Anda adalah seorang Dokter, silahkan Login terlebih dahulu untuk memulai melayani Pasien!</p>
                    <a class="feature-link" href="http://<?= $_SERVER['HTTP_HOST'] ?>/poliklinik/pages/auth/login.php">
                        Klik Link Berikut <i class="icon-arrow-right"></i>
                    </a>
                </div>
            </div>
        </section>
    <?php endif ?>
    

    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Poliklinik. All rights reserved.</p>
            <div class="social-links">
                <a href="#" class="social-link">Facebook</a>
                <a href="#" class="social-link">Twitter</a>
                <a href="#" class="social-link">Instagram</a>
            </div>
        </div>
    </footer>
</body>

</html>
