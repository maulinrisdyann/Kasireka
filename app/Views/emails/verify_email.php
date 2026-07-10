<!DOCTYPE html>
<html>
<body>
    <h2>Halo, <?= esc($name) ?></h2>
    <p>
        Terima kasih telah mendaftar di Kasireka.
    </p>
    <p>
        Silakan klik tombol berikut untuk memverifikasi email Anda.
    </p>
    <p>
        <a
            href="<?= $verifyLink ?>"
            style="padding:12px 20px;background:#0d6efd;color:#fff;text-decoration:none;">
            Verifikasi Email
        </a>
    </p>
    <p>
        Jika tombol tidak berfungsi, salin link berikut:
    </p>
    <p>
        <?= $verifyLink ?>
    </p>
</body>
</html>