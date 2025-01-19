<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk Baru</title>
    <style>
        /* CSS untuk tampilan */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        textarea {
            resize: none;
            height: 80px;
        }
        button {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        button:hover {
            background-color: #0056b3;
        }

        /* Modal Styling */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 300px;
            text-align: center;
        }
        .modal-content p {
            margin: 0;
            font-size: 16px;
            color: #333;
        }
        .modal-content.success p {
            color: green;
        }
        .modal-content.error p {
            color: red;
        }
        .modal-content button {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            margin-top: 15px;
            cursor: pointer;
        }
        .modal-content button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Produk Baru</h1>

        <?php
        $nama = $harga = $deskripsi = "";
        $errors = [];
        $successMessage = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nama = trim($_POST['nama']);
            $harga = trim($_POST['harga']);
            $deskripsi = trim($_POST['deskripsi']);

            // Validasi input
            if (empty($nama)) {
                $errors[] = "Nama produk tidak boleh kosong.";
            }
            if (empty($harga) || !is_numeric($harga) || $harga <= 0) {
                $errors[] = "Harga harus berupa angka positif.";
            }
            if (empty($deskripsi)) {
                $errors[] = "Deskripsi tidak boleh kosong.";
            }

            // Jika tidak ada error
            if (empty($errors)) {
                $successMessage = "Produk berhasil ditambahkan!";
                echo "<script>
                    window.addEventListener('load', () => {
                        showSuccessModal('$successMessage');
                    });
                </script>";
                // Reset input
                $nama = $harga = $deskripsi = "";
            } else {
                // Kirim pesan error ke JavaScript
                echo "<script>
                    const errorMessages = " . json_encode($errors) . ";
                    window.addEventListener('load', () => {
                        showErrorModal(errorMessages);
                    });
                </script>";
            }
        }
        ?>

        <!-- Form Input -->
        <form method="post" action="">
            <label for="nama">Nama Produk:</label>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($nama); ?>">

            <label for="harga">Harga Produk:</label>
            <input type="text" id="harga" name="harga" value="<?php echo htmlspecialchars($harga); ?>">

            <label for="deskripsi">Deskripsi Produk:</label>
            <textarea id="deskripsi" name="deskripsi"><?php echo htmlspecialchars($deskripsi); ?></textarea>

            <button type="submit">Tambah Produk</button>
        </form>
    </div>

    <!-- Modal untuk pesan -->
    <div id="messageModal" class="modal">
        <div class="modal-content" id="modalContent">
            <p id="modalMessages"></p>
            <button onclick="closeModal()">Tutup</button>
        </div>
    </div>

    <script>
        // JavaScript untuk menampilkan modal
        function showErrorModal(errors) {
            const modal = document.getElementById('messageModal');
            const modalContent = document.getElementById('modalContent');
            const messages = errors.join('<br>');
            modalContent.classList.remove('success');
            modalContent.classList.add('error');
            document.getElementById('modalMessages').innerHTML = messages;
            modal.style.display = 'flex';
        }

        function showSuccessModal(message) {
            const modal = document.getElementById('messageModal');
            const modalContent = document.getElementById('modalContent');
            modalContent.classList.remove('error');
            modalContent.classList.add('success');
            document.getElementById('modalMessages').innerHTML = message;
            modal.style.display = 'flex';
        }

        function closeModal() {
            const modal = document.getElementById('messageModal');
            modal.style.display = 'none';
        }
    </script>
</body>
</html>
