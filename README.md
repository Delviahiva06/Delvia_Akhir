# Delvia_Akhir - CodeIgniter 3.1.13 Project

## Overview
Project ini adalah aplikasi web yang dibangun menggunakan CodeIgniter 3.1.13 framework.

## Repository
🌐 **GitHub**: [https://github.com/Delviahiva06/Delvia_Akhir.git](https://github.com/Delviahiva06/Delvia_Akhir.git)

## Requirements
- PHP >= 5.3.7
- MySQL/MariaDB
- Apache/Nginx web server
- XAMPP (recommended for local development)

## Installation

### 1. Clone Repository
```bash
git clone https://github.com/Delviahiva06/Delvia_Akhir.git
cd Delvia_Akhir
```

### 2. Setup Web Server
1. Copy project ke folder `htdocs` XAMPP
2. Start Apache dan MySQL di XAMPP Control Panel
3. Akses project melalui: `http://localhost/Delvia_Akhir/CodeIgniter-3.1.13/`

### 3. Database Configuration
1. Edit file `CodeIgniter-3.1.13/application/config/database.php`
2. Sesuaikan konfigurasi database:
```php
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'nama_database_anda',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
```

## Project Structure
```
Delvia_Akhir/
├── CodeIgniter-3.1.13/
│   ├── application/
│   │   ├── config/          # Konfigurasi aplikasi
│   │   ├── controllers/     # Controller files
│   │   ├── models/          # Model files
│   │   ├── views/           # View files
│   │   ├── cache/           # Cache files
│   │   └── logs/            # Log files
│   ├── system/              # CodeIgniter core files
│   └── index.php            # Entry point
├── .gitignore               # Git ignore rules
└── README.md               # This file
```

## Current Features
- Welcome page dengan CodeIgniter 3.1.13
- Error handling pages
- Basic MVC structure

## Development

### Adding New Controllers
1. Buat file baru di `application/controllers/`
2. Extend `CI_Controller`
3. Contoh:
```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MyController extends CI_Controller {
    public function index() {
        $this->load->view('my_view');
    }
}
```

### Adding New Models
1. Buat file baru di `application/models/`
2. Extend `CI_Model`
3. Contoh:
```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MyModel extends CI_Model {
    public function get_data() {
        return $this->db->get('table_name')->result();
    }
}
```

### Adding New Views
1. Buat file baru di `application/views/`
2. Gunakan PHP dan HTML
3. Contoh:
```php
<!DOCTYPE html>
<html>
<head>
    <title>My View</title>
</head>
<body>
    <h1><?php echo $title; ?></h1>
    <p><?php echo $content; ?></p>
</body>
</html>
```

## Configuration

### Base URL
Edit `application/config/config.php`:
```php
$config['base_url'] = 'http://localhost/Delvia_Akhir/CodeIgniter-3.1.13/';
```

### Environment
Set environment di `index.php`:
```php
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');
```

## Troubleshooting

### Common Issues
1. **404 Error**: Pastikan mod_rewrite Apache aktif
2. **Database Connection Error**: Periksa konfigurasi database
3. **Permission Error**: Pastikan folder cache dan logs writable

### Debug Mode
Untuk development, aktifkan debug mode di `application/config/config.php`:
```php
$config['log_threshold'] = 4;
```

## Contributing
1. Fork repository
2. Buat branch baru: `git checkout -b feature/nama-fiturnya`
3. Commit changes: `git commit -m 'Add new feature'`
4. Push ke branch: `git push origin feature/nama-fiturnya`
5. Buat Pull Request

## License
This project is licensed under the MIT License.

## Contact
- **Developer**: Delviahiva06
- **Email**: delviahiva06@gmail.com
- **GitHub**: [@Delviahiva06](https://github.com/Delviahiva06)

## Changelog
- **v1.0.0** - Initial release dengan CodeIgniter 3.1.13 