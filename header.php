<?php
include "proses/connect.php";
$query = mysqli_query($conn, "SELECT * FROM tb_user WHERE username='$_SESSION[username_recafe]'");
$record = mysqli_fetch_array($query);
?>
<nav class="navbar navbar-expand navbar-dark bg-primary sticky-top">
    <div class="container-lg">
        <a class="navbar-brand" href="."><i class="bi bi-cup-hot"></i> ReCafe</a>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <?php echo $hasil["username"]; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end mt-2">
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                data-bs-target="#ModalUbahProfile"><i class="bi bi-person-circle"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                data-bs-target="#ModalUbahPassword"><i class="bi bi-key"></i> Ubah Password</a></li>
                        <li><a class="dropdown-item" href="logout"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Modal Ubah Password -->
<div class="modal fade" id="ModalUbahPassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Password</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate action="proses/proses_ubah_password.php" method="POST"
                id="formUbahPassword">
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?php echo $hasil['id']; ?>">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-floating mb-3">
                                <input disabled type="email" class="form-control" id="floatingInput"
                                    placeholder="name@gmail.com" name="username" required
                                    value="<?php echo $_SESSION['username_recafe']; ?>">
                                <label for="floatingInput">Username</label>
                                <div class="invalid-feedback">
                                    Masukkan username.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingPassword" name="password_lama"
                                    required>
                                <label for="floatingPassword">Password Lama</label>
                                <div class="invalid-feedback">
                                    Masukkan Password lama.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingPasswordbaru"
                                    name="password_baru" required>
                                <label for="floatingPasswordbaru">Password Baru</label>
                                <div class="invalid-feedback">
                                    Masukkan Password baru.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingrePasswordbaru"
                                    name="repassword_baru" required>
                                <label for="floatingrePasswordbaru">Konfirmasi Password Baru</label>
                                <div class="invalid-feedback">
                                    Masukkan Konfirmasi Password baru.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="ubah_password_validate"
                        value="12345">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- akhir Modal Ubah Password -->
<!-- Modal Ubah Profile -->
<div class="modal fade" id="ModalUbahProfile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Profile</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate action="proses/proses_ubah_profile.php" method="POST"
                id="formUbahProfile">
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?php echo $hasil['id']; ?>">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-floating mb-3">
                                <input disabled type="email" class="form-control" id="floatingInput"
                                    placeholder="name@gmail.com" name="username" required
                                    value="<?php echo $_SESSION['username_recafe']; ?>">
                                <label for="floatingInput">Username</label>
                                <div class="invalid-feedback">
                                    Masukkan username.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingNama" name="nama" required
                                    value="<?php echo $hasil['nama']; ?>">
                                <label for="floatingNama">Nama</label>
                                <div class="invalid-feedback">
                                    Masukkan Nama Anda.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="floatingInput" name="nohp" required
                                    value="<?php echo $record['nohp']; ?>">
                                <label for="floatingInput">Nomor HP</label>
                                <div class="invalid-feedback">
                                    Masukkan Nomor HP.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-floating mb-3">
                                <textarea class="form-control" name="alamat" id="" style="height: 100px();"
                                    required><?php echo $record['alamat']; ?></textarea>
                                <label for="floatingrePasswordbaru">Alamat</label>
                                <div class="invalid-feedback">
                                    Masukkan Alamat.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="ubah_profile_validate"
                        value="12345">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- akhir Modal Ubah Profile -->