# QR Code Registration System

A complete QR-based registration and attendance tracking system. This system allows users to register, generate a unique QR code, download it, and scan it for attendance tracking.

## Features
- **User Registration**: Users can register and get a unique QR code.
- **QR Code Generation**: Each registered user receives a QR code.
- **QR Code Download**: Users can download their QR codes.
- **QR Code Scanning**: Admin can scan QR codes to update attendance.
- **Real-time Scanning**: Uses the camera for live QR code scanning.
- **Attendance Marking**: Once scanned, the admin updates the user's attendance from 0 to 1.

## Technologies Used
- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP, MySQL
- **QR Code Library**: PHP QR Code Library
- **Scanner**: JavaScript-based QR scanner

## Installation Guide
### Prerequisites
- XAMPP/WAMP (for running PHP & MySQL locally)
- A web browser

### Steps to Install
1. Clone the repository:
   ```sh
   git clone https://github.com/yourusername/qr-code-registration.git
   ```
2. Move the project folder to your server directory (e.g., `htdocs` for XAMPP).
3. Import the database:
   - Open `phpMyAdmin`
   - Create a new database (e.g., `qr_system`)
   - Import `database.sql` file
4. Configure the database connection:
   - Open `config.php`
   - Update the database credentials:
     ```php
     $host = 'localhost';
     $user = 'root';
     $password = '';
     $database = 'qr_system';
     ```
5. Start your local server (Apache & MySQL).
6. Open the project in a browser:
   ```
   http://localhost/qr-code-registration/
   ```

## Usage
1. **User Registration**: Fill out the form to register.
2. **Download QR Code**: After registration, download the QR code.
3. **Scan QR Code**: Admin scans the QR code using the built-in scanner.
4. **Attendance Update**: The system updates attendance upon scanning.

## Screenshots
![Registration Page](screenshots/register.png)
![QR Code](screenshots/qrcode.png)
![Scanner](screenshots/scanner.png)

## Future Enhancements
- Email verification for registration.
- Auto-expiry QR codes for security.
- Detailed attendance reports.
- Mobile app support.

## Contributing
Pull requests are welcome! Feel free to submit issues and suggestions.

## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Contact
For any queries or suggestions, contact: [your email or website]

