<!DOCTYPE html>
<html>
<body>
    <h2>Halo, <?= esc($name) ?></h2>
    <p>
        Kami menerima permintaan reset password akun Kasireka Anda.
    </p>
    <p>
        Klik tombol berikut.
    </p>
    <p>
        <a
            href="<?= $resetLink ?>"
            style="padding:12px 20px;background:#198754;color:#fff;text-decoration:none;">
            Reset Password
        </a>
    </p>
    <p>
        Apabila Anda tidak merasa melakukan permintaan ini, abaikan email ini.
    </p>
    <p>
        Link:
    </p>
    <p>
        <?= $resetLink ?>
    </p>
</body>
</html>