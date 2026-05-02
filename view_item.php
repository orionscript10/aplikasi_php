<?php
include "proses/connect.php";
$order = isset($_GET['order']) ? $_GET['order'] : '';
$orderPaid = false;
$result = [];
$kode = '';
$select_kat_menu = mysqli_query($conn, "SELECT id_kat_menu, kategori_menu FROM tb_kategori_menu");
$query = mysqli_query($conn, "SELECT tb_list_order.id_list_order AS id_list_order, tb_list_order.kode_order, tb_list_order.menu, tb_list_order.jumlah, tb_list_order.status, tb_list_order.catatan, tb_order.meja, tb_order.pelanggan, tb_daftar_menu.id AS menu_id, tb_daftar_menu.nama_menu, tb_daftar_menu.harga, tb_daftar_menu.keterangan, tb_daftar_menu.kategori, tb_bayar.id_bayar AS id_bayar, (tb_daftar_menu.harga * tb_list_order.jumlah) AS total_harga FROM tb_list_order
    LEFT JOIN tb_order ON tb_order.id_order = tb_list_order.`kode_order`
    LEFT JOIN tb_daftar_menu ON tb_daftar_menu.id = tb_list_order.menu
    LEFT JOIN tb_bayar ON tb_bayar.id_bayar = tb_order.id_order
    WHERE tb_list_order.`kode_order` = '$order'");

$kode = $_GET['order'];
$meja = $_GET['meja'];
$pelanggan = $_GET['pelanggan'];
while ($record = mysqli_fetch_array($query)) {
  $result[] = $record;
  if (!empty($record['id_bayar'])) {
    $orderPaid = true;
  }
}
?>
<div class="col-lg-9 mt-2 rounded">
  <div class="card">
    <div class="card-header">
      Halaman View Item
    </div>
    <div class="card-body">
      <a href="reports" class="btn btn-primary mb-3"><i class="bi bi-arrow-left-circle"></i></a>
      <div class="row">
        <div class="col-lg-3">
          <div class="form-floating mb-3">
            <input disabled type="text" class="form-control" id="kodeorder" value="<?php echo $kode; ?>">
            <label for="uploadFoto">Kode Order</label>
          </div>
        </div>
        <div class="col-lg-2">
          <div class="form-floating mb-2">
            <div class="form-floating mb-3">
              <input disabled type="text" class="form-control" id="meja" value="<?php echo $meja; ?>">
              <label for="uploadFoto">Meja</label>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="form-floating mb-3">
            <div class="form-floating mb-3">
              <input disabled type="text" class="form-control" id="pelanggan" value="<?php echo $pelanggan; ?>">
              <label for="uploadFoto">Pelanggan</label>
            </div>
          </div>
        </div>
      </div>
      <?php
      if (empty($result)) {
        echo "<div class='alert alert-danger'>Data menu Tidak Ada</div>";
      } else {
        ?>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr class="text-nowrap">
                <th scope="col">Menu</th>
                <th scope="col">Harga</th>
                <th scope="col">Qty</th>
                <th scope="col">Status</th>
                <th scope="col">Catatan</th>
                <th scope="col">Total</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $total = 0;
              foreach ($result as $row) {
                ?>
                <tr>
                  <td>
                    <?php echo $row['nama_menu']; ?>
                  </td>
                  <td>
                    <?php echo number_format($row['harga'], 0, ',', '.'); ?>
                  </td>
                  <td>
                    <?php echo $row['jumlah']; ?>
                  </td>
                  <td>
                    <?php
                    switch ($row['status']) {
                      case 0:
                        echo "<span class='badge bg-warning text-dark'>Menunggu</span>";
                        break;
                      case 1:
                        echo "<span class='badge bg-info text-white'>Masuk ke Dapur</span>";
                        break;
                      case 2:
                        echo "<span class='badge bg-success text-white'>Siap Saji</span>";
                        break;
                      default:
                        echo "<span class='badge bg-secondary text-white'>Tidak Diketahui</span>";
                    }
                    ?>
                  </td>
                  <td>
                    <?php echo $row['catatan']; ?>
                  </td>
                  <td>
                    <?php echo number_format($row['total_harga'], 0, ',', '.'); ?>
                  </td>
                </tr>
                <?php
                $total += $row['total_harga'];
              } ?>
              <tr>
                <td colspan="4" class="fw-bold"><b>Total Harga :</b></td>
                <td><b>
                  </b></td>
                <td class="fw-bold">
                  <?php echo number_format($total, 0, ',', '.'); ?>
                </td>
              </tr>
            </tbody>
          </table>

        </div>
        <?php
      }
      ?>

      <?php
      foreach ($result as $row) {
        ?>
        <!-- Modal view -->
        <div class="modal fade" id="ModalView<?php echo $row['kode_order']; ?>" tabindex="-1"
          aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl modal-fullscreen-md-down">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Menu Makanan dan Minuman</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form class="needs-validation" novalidate action="proses/proses_input_menu.php" method="POST"
                  enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="Nama Menu"
                          value="<?php echo $row['nama_menu']; ?>" readonly>
                        <label for="floatingInput">Nama Menu</label>
                        <div class="invalid-feedback">
                          Masukkan Nama Menu.
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingPassword" placeholder="Keterangan"
                          name="keterangan" value="<?php echo $row['keterangan']; ?>" readonly>
                        <label for="floatingPassword">Keterangan</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="form-floating mb-3">
                        <select class="form-select" aria-label="Default select example" name="kat_menu" required disabled>
                          <option selected hidden>Pilih Kategori Menu</option>
                          <?php
                          foreach ($select_kat_menu as $value) {
                            if ($row['kategori'] == $value['id_kat_menu']) {
                              echo "<option selected value=" . $value['id_kat_menu'] . ">$value[kategori_menu]</option>";
                            } else {
                              echo "<option value=" . $value['id_kat_menu'] . ">$value[kategori_menu]</option>";
                            }
                          }
                          ?>
                        </select>
                        <label for="floatingInput">Kategori Makanan dan Minuman</label>
                        <div class="invalid-feedback">
                          Pilih kategori menu Makanan dan Minuman.
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="floatingInput" value="<?php echo $row['harga']; ?>"
                          readonly>
                        <label for="floatingInput">Harga</label>
                        <div class="invalid-feedback">
                          Masukkan harga.
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="floatingInput" placeholder="Stok" name="stok"
                          value="<?php echo $row['stok']; ?>" readonly>
                        <label for="floatingInput">Stok</label>
                        <div class="invalid-feedback">
                          Masukkan stok.
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="input_menu_validate" value="12345">Save
                      changes</button>
                  </div>
                </form>
              </div>

            </div>
          </div>
        </div>
        <!-- akhir Modal view -->
        <?php
      }
      ?>
      <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (() => {
          'use strict'

          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          const forms = document.querySelectorAll('.needs-validation')

          // Loop over them and prevent submission
          Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
              if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
              }

              form.classList.add('was-validated')
            }, false)
          })
        })()
      </script>