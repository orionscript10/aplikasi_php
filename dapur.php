<?php
include "proses/connect.php";
$order = isset($_GET['order']) ? $_GET['order'] : '';
$orderPaid = false;
$result = [];
$kode = '';
$select_kat_menu = mysqli_query($conn, "SELECT * FROM tb_kategori_menu");
$query = mysqli_query($conn, "SELECT tb_list_order.id_list_order AS id_list_order, tb_list_order.kode_order, tb_list_order.menu, tb_list_order.jumlah, tb_list_order.status, tb_list_order.catatan, tb_order.meja, tb_order.pelanggan, tb_order.waktu_order, tb_daftar_menu.id AS menu_id, tb_daftar_menu.nama_menu, tb_daftar_menu.harga, tb_daftar_menu.keterangan, tb_daftar_menu.kategori, tb_bayar.id_bayar AS id_bayar, (tb_daftar_menu.harga * tb_list_order.jumlah) AS total_harga FROM tb_list_order
    LEFT JOIN tb_order ON tb_order.id_order = tb_list_order.`kode_order`
    LEFT JOIN tb_daftar_menu ON tb_daftar_menu.id = tb_list_order.menu
    LEFT JOIN tb_bayar ON tb_bayar.id_bayar = tb_order.id_order
    ORDER BY waktu_order ASC");

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
      Halaman Dapur
    </div>
    <div class="card-body">
      <?php
      if (empty($result)) {
        echo "<div class='alert alert-danger'>Data menu Tidak Ada</div>";
      } else {
        ?>
        <div class="table-responsive">
          <table id="example" class="table table-hover">
            <thead>
              <tr class="text-nowrap">
                <th scope="col">No</th>
                <th scope="col">Kode Order</th>
                <th scope="col">Waktu Order</th>
                <th scope="col">Menu</th>
                <th scope="col">Qty</th>
                <th scope="col">Catatan</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              $total = 0;
              foreach ($result as $row) {
                if ($row['status'] != 2) {
                  ?>
                  <tr>
                    <td>
                      <?php echo $no++ ?>
                    </td>
                    <td>
                      <?php echo $row['kode_order']; ?>
                    </td>
                    <td>
                      <?php echo $row['waktu_order']; ?>
                    </td>
                    <td>
                      <?php echo $row['nama_menu']; ?>
                    <td>
                      <?php echo $row['jumlah']; ?>
                    </td>
                    <td>
                      <?php echo $row['catatan']; ?>
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
                      <div class="d-flex">
                        <button
                          class="<?php echo (!empty($row['status'])) ? "btn btn-secondary disabled" : "btn btn-primary"; ?>"
                          data-bs-target="#terima<?php echo $row['id_list_order']; ?>" data-bs-toggle="modal">Terima</button>
                        <button
                          class="<?php echo (empty($row['status']) || $row['status'] != 1) ? "btn btn-secondary text-nowrap disabled" : "btn btn-success text-nowrap"; ?>"
                          data-bs-target="#siapsaji<?php echo $row['id_list_order']; ?>" data-bs-toggle="modal">Siap
                          Saji</button>
                      </div>
                    </td>
                  </tr>
                  <?php
                }
              } ?>
            </tbody>
          </table>

        </div>
        <?php
      }
      ?>
      <?php
      foreach ($result as $row) {
        ?>
        <!-- Modal Terima Dapur -->
        <div class="modal fade" id="terima<?php echo $row['id_list_order']; ?>" tabindex="-1"
          aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl modal-fullscreen-md-down">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Terima Order</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form class="needs-validation" novalidate action="proses/proses_terima_order_item.php" method="POST">
                  <input type="hidden" name="id" value="<?php echo $row['id_list_order']; ?>">
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="form-floating mb-3">
                        <select disabled class="form-select" aria-label="Default select example" name="menu" required>
                          <option selected hidden>Pilih Menu</option>
                          <?php
                          $select_menu = mysqli_query($conn, "SELECT * FROM tb_daftar_menu");
                          while ($menu_row = mysqli_fetch_array($select_menu)) {
                            $selected = ($menu_row['id'] == $row['menu']) ? ' selected' : '';
                            echo "<option value='" . $menu_row['id'] . "'" . $selected . ">" . $menu_row['nama_menu'] . " - Rp. " . number_format($menu_row['harga'], 0, ',', '.') . "</option>";
                          }
                          ?>
                        </select>
                        <label for="menu">Menu</label>
                        <div class="invalid-feedback">
                          Pilih menu.
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-floating mb-3">
                        <input disabled type="number" class="form-control" id="jumlah" placeholder="Jumlah" name="jumlah"
                          value="<?php echo $row['jumlah']; ?>" required>
                        <label for="jumlah">Jumlah</label>
                        <div class="invalid-feedback">
                          Masukkan jumlah.
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="catatan" placeholder="Catatan" name="catatan"
                          value="<?php echo $row['catatan']; ?>">
                        <label for="catatan">Catatan</label>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="terima_order_validate" value="12345">Terima
                      Order</button>
                  </div>
                </form>
              </div>

            </div>
          </div>
        </div>
        <!-- akhir Modal terima dapur -->
        <!-- Modal Siap Saji -->
        <div class="modal fade" id="siapsaji<?php echo $row['id_list_order']; ?>" tabindex="-1"
          aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl modal-fullscreen-md-down">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Siap Saji</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form class="needs-validation" novalidate action="proses/proses_siapsaji_order_item.php" method="POST">
                  <input type="hidden" name="id" value="<?php echo $row['id_list_order']; ?>">
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="form-floating mb-3">
                        <select disabled class="form-select" aria-label="Default select example" name="menu" required>
                          <option selected hidden>Pilih Menu</option>
                          <?php
                          $select_menu = mysqli_query($conn, "SELECT * FROM tb_daftar_menu");
                          while ($menu_row = mysqli_fetch_array($select_menu)) {
                            $selected = ($menu_row['id'] == $row['menu']) ? ' selected' : '';
                            echo "<option value='" . $menu_row['id'] . "'" . $selected . ">" . $menu_row['nama_menu'] . " - Rp. " . number_format($menu_row['harga'], 0, ',', '.') . "</option>";
                          }
                          ?>
                        </select>
                        <label for="menu">Menu</label>
                        <div class="invalid-feedback">
                          Pilih menu.
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-floating mb-3">
                        <input disabled type="number" class="form-control" id="jumlah" placeholder="Jumlah" name="jumlah"
                          value="<?php echo $row['jumlah']; ?>" required>
                        <label for="jumlah">Jumlah</label>
                        <div class="invalid-feedback">
                          Masukkan jumlah.
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="catatan" placeholder="Catatan" name="catatan"
                          value="<?php echo $row['catatan']; ?>">
                        <label for="catatan">Catatan</label>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="siapsaji_order_validate" value="12345">Siap
                      Saji</button>
                  </div>
                </form>
              </div>

            </div>
          </div>
        </div>
        <!-- akhir Modal Siap saji -->

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