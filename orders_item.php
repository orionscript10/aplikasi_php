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
  //$kode = $record['id_order'];
  //$meja = $record['meja'];
  //$pelanggan = $record['pelanggan'];
}
?>
<div class="col-lg-9 mt-2 rounded">
  <div class="card">
    <div class="card-header">
      Halaman Order Item
    </div>
    <div class="card-body">
      <a href="orders" class="btn btn-primary mb-3"><i class="bi bi-arrow-left-circle"></i></a>
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
      <!-- Modal tambah Item -->
      <div class="modal fade" id="tambahItem" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-fullscreen-md-down">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Menu Makanan dan Minuman</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form class="needs-validation" novalidate action="proses/proses_input_order_item.php" method="POST">
                <input type="hidden" name="kode_order" value="<?php echo $kode; ?>">
                <input type="hidden" name="meja" value="<?php echo $meja; ?>">
                <input type="hidden" name="pelanggan" value="<?php echo $pelanggan; ?>">
                <div class="row">
                  <div class="col-lg-7">
                    <div class="form-floating mb-3">
                      <select class="form-select" aria-label="Default select example" name="menu" required>
                        <option selected hidden>Pilih Menu</option>
                        <?php
                        $select_menu = mysqli_query($conn, "SELECT * FROM tb_daftar_menu");
                        while ($row_menu = mysqli_fetch_array($select_menu)) {
                          echo "<option value=" . $row_menu['id'] . ">$row_menu[nama_menu] - Rp. " . number_format($row_menu['harga'], 0, ',', '.') . "</option>";
                        }
                        ?>
                      </select>
                      <label for="floatingInput">Menu Makanan dan Minuman</label>
                      <div class="invalid-feedback">
                        Pilih menu.
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-5">
                    <div class="form-floating mb-3">
                      <input type="number" class="form-control" id="floatingInput" placeholder="Jumlah" name="jumlah"
                        required>
                      <label for="floatingInput">Jumlah</label>
                      <div class="invalid-feedback">
                        Masukkan jumlah.
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="floatingInput" placeholder="Catatan" name="catatan"
                        required>
                      <label for="floatingInput">Catatan</label>
                      <div class="invalid-feedback">
                        Masukkan Catatan.
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" name="input_order_item_validate" value="12345">Tambah
                    Item</button>
                </div>
              </form>
            </div>

          </div>
        </div>
      </div>
      <!-- akhir Modal tambah Item -->
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
                <th scope="col">Aksi</th>
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
                  <td>
                    <div class="d-flex">
                      <button
                        class="<?php echo (!empty($row['id_bayar'])) ? "btn btn-secondary disabled" : "btn btn-warning"; ?>"
                        data-bs-target="#ModalEdit<?php echo $row['id_list_order']; ?>" data-bs-toggle="modal"><i
                          class="bi bi-pencil-square"></i></button>
                      <button
                        class="<?php echo (!empty($row['id_bayar'])) ? "btn btn-secondary disabled" : "btn btn-danger"; ?>"
                        data-bs-target="#ModalDelete<?php echo $row['id_list_order']; ?>" data-bs-toggle="modal"><i
                          class="bi bi-trash"></i></button>
                    </div>
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
      <div class="no-print">
        <button class="<?php echo ($orderPaid) ? 'btn btn-secondary disabled' : 'btn btn-success'; ?>"
          data-bs-target="#tambahItem" data-bs-toggle="modal" <?php echo ($orderPaid) ? 'disabled' : ''; ?>><i
            class="bi bi-plus-circle-fill"></i> Item</i></button>
        <button class="btn btn-primary btn-sm me-1 <?php echo ($orderPaid) ? 'disabled' : ''; ?>"
          data-bs-target="#bayar" data-bs-toggle="modal" <?php echo ($orderPaid) ? 'disabled' : ''; ?>><i
            class="bi bi-cash-coin"></i> Bayar</button>
        <button class="btn btn-info" onclick="printStruk()"><i class="bi bi-printer"></i> Cetak Struk</button>
      </div>
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
        <!-- Modal Edit -->
        <div class="modal fade" id="ModalEdit<?php echo $row['id_list_order']; ?>" tabindex="-1"
          aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl modal-fullscreen-md-down">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Menu Makanan dan Minuman</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form class="needs-validation" novalidate action="proses/proses_edit_order_item.php" method="POST">
                  <input type="hidden" name="id" value="<?php echo $row['id_list_order']; ?>">
                  <input type="hidden" name="kode_order" value="<?php echo $row['kode_order']; ?>">
                  <input type="hidden" name="meja" value="<?php echo $row['meja']; ?>">
                  <input type="hidden" name="pelanggan" value="<?php echo $row['pelanggan']; ?>">
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="form-floating mb-3">
                        <select class="form-select" aria-label="Default select example" name="menu" required>
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
                        <input type="number" class="form-control" id="jumlah" placeholder="Jumlah" name="jumlah"
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
                    <button type="submit" class="btn btn-primary" name="edit_order_item_validate" value="12345">Edit
                      Order</button>
                  </div>
                </form>
              </div>

            </div>
          </div>
        </div>
        <!-- akhir Modal Edit -->
        <!-- Modal Delete -->
        <div class="modal fade" id="ModalDelete<?php echo $row['id_list_order']; ?>" tabindex="-1"
          aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-md modal-fullscreen-md-down">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Order Item</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form class="needs-validation" novalidate action="proses/proses_delete_order_item.php" method="POST">
                  <input type="hidden" name="id" value="<?php echo $row['id_list_order']; ?>">
                  <input type="hidden" name="kode_order" value="<?php echo $row['kode_order']; ?>">
                  <input type="hidden" name="meja" value="<?php echo $row['meja']; ?>">
                  <input type="hidden" name="pelanggan" value="<?php echo $row['pelanggan']; ?>">
                  <div class="row">
                    <div class="col-lg-12">
                      Apakah anda yakin ingin menghapus order item
                      <b><?php echo $row['nama_menu']; ?></b>?
                    </div>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger" name="delete_order_item_validate"
                  value="12345">Hapus</button>
              </div>
              </form>
            </div>
          </div>
        </div>
        <!-- akhir Modal Delete -->
        <?php
      }
      ?>
      <!-- Modal bayar -->
      <div class="modal fade" id="bayar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-fullscreen-md-down">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Pembayaran</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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
                          <?php echo $row['status']; ?>
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
              <span class="text-danger fst-italic fw-bold">Apakah Anda yakin ingin melakukan pembayaran ini?</span>
              <form class="needs-validation" novalidate action="proses/proses_bayar.php" method="POST">
                <input type="hidden" name="kode_order" value="<?php echo $kode; ?>">
                <input type="hidden" name="meja" value="<?php echo $meja; ?>">
                <input type="hidden" name="pelanggan" value="<?php echo $pelanggan; ?>">
                <input type="hidden" name="total" value="<?php echo $total; ?>">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-floating mb-3">
                      <input type="number" class="form-control" id="floatingInput" placeholder="Jumlah" name="uang"
                        required>
                      <label for="floatingInput">Nominal Uang</label>
                      <div class="invalid-feedback">
                        Masukkan Nominal Uang.
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary" name="bayar_validate" value="12345">Bayar</button>
                    </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- akhir Modal bayar-->
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

      <style>
        @media print {
          .no-print {
            display: none !important;
          }
        }
      </style>

      <div id="strukContent" style="display:none;">
        <div class="receipt-card">
          <div class="receipt-header">
            <div>
              <p class="receipt-brand">ReCafe</p>
              <p class="receipt-title">Struk Pembayaran</p>
            </div>
            <p class="receipt-label">Terima kasih telah memesan!</p>
          </div>
          <div class="receipt-info">
            <div class="receipt-info-item">
              <span>Kode Order</span>
              <strong><?php echo $kode; ?></strong>
            </div>
            <div class="receipt-info-item">
              <span>Meja</span>
              <strong><?php echo $meja; ?></strong>
            </div>
            <div class="receipt-info-item">
              <span>Pelanggan</span>
              <strong><?php echo $pelanggan; ?></strong>
            </div>
            <div class="receipt-info-item">
              <span>Waktu Order</span>
              <strong><?php echo date('d-m-Y H:i:s'); ?></strong>
            </div>
          </div>
          <table class="receipt-table">
            <thead>
              <tr>
                <th>Menu</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <?php
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
                    <?php echo number_format($row['total_harga'], 0, ',', '.'); ?>
                  </td>
                </tr>
                <?php
              } ?>
            </tbody>
          </table>
          <div class="receipt-summary">
            <span>Total Harga</span>
            <strong>Rp <?php echo number_format($total, 0, ',', '.'); ?></strong>
          </div>
          <p class="receipt-footer">Terima kasih telah memesan di ReCafe. Semoga hari Anda menyenangkan!</p>
        </div>
      </div>

      <script>
        function printStruk() {
          var strukContent = document.getElementById('strukContent').innerHTML;
          var printFrame = document.createElement('iframe');
          printFrame.style.position = 'absolute';
          printFrame.style.left = '-9999px';
          printFrame.style.width = '0';
          printFrame.style.height = '0';
          document.body.appendChild(printFrame);

          var doc = printFrame.contentDocument || printFrame.contentWindow.document;
          doc.open();
          doc.write('<!doctype html><html><head><meta charset="utf-8"><title>Struk ReCafe</title><style>' +
            'body{margin:0;padding:20px;background:#f4f6fb;color:#111;font-family:Inter,system-ui,-apple-system,Segoe UI,sans-serif;}' +
            '.receipt-card{max-width:720px;margin:0 auto;background:#ffffff;border-radius:24px;box-shadow:0 24px 60px rgba(15,23,42,0.08);padding:28px;}' +
            '.receipt-header{display:flex;justify-content:space-between;align-items:flex-start;gap:16px;margin-bottom:24px;}' +
            '.receipt-brand{margin:0;font-size:30px;font-weight:700;color:#0f172a;letter-spacing:.1em;}' +
            '.receipt-title{margin:4px 0 0;font-size:14px;text-transform:uppercase;color:#64748b;letter-spacing:.15em;}' +
            '.receipt-label{margin:0;color:#334155;font-size:14px;}' +
            '.receipt-info{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:12px;margin-bottom:24px;}' +
            '.receipt-info-item{background:#f8fafc;border-radius:16px;padding:14px 16px;display:flex;justify-content:space-between;align-items:center;}' +
            '.receipt-info-item span{font-size:12px;color:#64748b;}' +
            '.receipt-info-item strong{font-size:14px;color:#0f172a;}' +
            '.receipt-table{width:100%;border-collapse:collapse;margin-bottom:24px;}' +
            '.receipt-table th,.receipt-table td{padding:14px 16px;border-bottom:1px solid #e2e8f0;text-align:left;}' +
            '.receipt-table th{background:#f8fafc;color:#0f172a;font-size:12px;text-transform:uppercase;letter-spacing:.08em;}' +
            '.receipt-table tbody tr:last-child td{border-bottom:none;}' +
            '.receipt-summary{display:flex;justify-content:space-between;align-items:center;padding:18px 0 0;border-top:1px solid #e2e8f0;font-size:16px;font-weight:700;color:#0f172a;}' +
            '.receipt-footer{margin-top:24px;font-size:13px;color:#64748b;line-height:1.6;}' +
            '</style></head><body>' + strukContent + '</body></html>');
          doc.close();
          printFrame.contentWindow.focus();
          printFrame.contentWindow.print();
          document.body.removeChild(printFrame);
        }
      </script>