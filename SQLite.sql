CREATE TABLE kurir (
id bigint UNSIGNED NOT NULL AUTO_INCREMENT, name varchar(255) DEFAULT NULL,
email varchar(255) DEFAULT NULL,
password varchar(255) NOT NULL,
3
SOAL INI BERSIFAT RAHASIA “HARUS DIKEMBALIKAN” |
MILIK UNIVERSITAS DIAN NUSANTARA
PRIMARY KEY (id)
   )
   ENGINE = INNODB;


CREATE TABLE `barang` (
`id` int(11) NOT NULL AUTO_INCREMENT, `kode_barang` varchar(10) NOT NULL, `nama_barang` varchar(200) DEFAULT NULL, `deskripsi` text DEFAULT NULL, `stok_barang` int(11) DEFAULT NULL, `harga_barang` int(11) DEFAULT NULL, PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE lokasi (
id int NOT NULL AUTO_INCREMENT, kode_lokasi varchar(10) DEFAULT NULL, nama_lokasi varchar(255) DEFAULT NULL, PRIMARY KEY (id)
   )
   ENGINE = INNODB;



CREATE TABLE `pengiriman` (
`id` int(11) NOT NULL AUTO_INCREMENT, `no_pengiriman` varchar(15) NOT NULL, `tanggal` date NOT NULL,
`lokasi_id` int(11) DEFAULT NULL, `barang_id` int(11) DEFAULT NULL, `jumlah_barang` int(11) NOT NULL, `harga_barang` int(11) DEFAULT NULL, `kurir_id ` int(11) DEFAULT NULL, PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1
