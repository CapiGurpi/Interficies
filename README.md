# Next Level Sports 🏆

A comprehensive sports event management platform that connects fans and event promoters. Discover upcoming sporting events, purchase tickets, follow your favorite sports, and organize events all in one place.

## 📋 Table of Contents

- [Features](#features)
- [Project Structure](#project-structure)
- [Technology Stack](#technology-stack)
- [Installation](#installation)
- [Usage](#usage)
- [User Roles](#user-roles)
- [Database](#database)
- [File Structure](#file-structure)
- [Contributing](#contributing)
- [License](#license)

## ✨ Features

### For Fans (Aficionados)
- 🔐 User registration and authentication
- 🎫 Browse and purchase tickets for sporting events
- 📰 Stay updated with latest sports news
- ⭐ Highlights and video galleries
- 👤 Personal profile management
- 🔔 Event notifications and alerts
- ❤️ Favorite sports tracking

### For Promoters
- 📝 Create and manage sporting events
- 🎯 Professional ticket sales management
- 📢 Publish sports news and updates
- 📊 Event promotion tools
- 💳 Secure payment processing
- 👥 Direct connection with fans

### General
- 🌍 Multi-sport platform (Football, Basketball, Tennis, F1, MotoGP, and more)
- 📱 Responsive design
- ♿ AAA accessibility compliance
- 🇪🇸 Spanish language interface

## 🏗️ Project Structure

```
Interficies/
├── Controller/
│   └── UserController.php          # User authentication and registration logic
├── Model/
│   ├── Aficionado.php              # Fan user model
│   ├── Promotor.php                # Promoter user model
│   ├── NextLvlBase.php             # Database connection base class
│   └── Bd.sql                      # Database schema
├── Vista/
│   ├── *.php                       # Main view pages
│   ├── css/                        # Stylesheets
│   ├── assets/                     # Images, videos, audio files
│   ├── events/                     # Event detail pages
│   ├── news/                       # News articles
│   ├── incoming/                   # Upcoming events
│   └── purchase/                   # Ticket purchase pages
└── README.md                       # This file
```

## 🛠️ Technology Stack

- **Backend**: PHP 7.x+
- **Frontend**: HTML5, CSS3, JavaScript
- **Database**: MySQL/MariaDB
- **Server**: Apache (XAMPP)
- **UI/UX**: Responsive design with modern CSS

## 📦 Installation

### Prerequisites
- XAMPP (or equivalent Apache + MySQL stack)
- PHP 7.0 or higher
- MySQL 5.7 or higher

### Setup Instructions

1. **Clone or place the project**
   ```bash
   # Place the Interficies folder in your htdocs directory
   cp -r Interficies/ /path/to/xampp/htdocs/EJERCICIOS/
   ```

2. **Create the database**
   ```bash
   # Import the SQL file
   mysql -u root -p < Model/Bd.sql
   ```

3. **Configure database connection**
   - Edit `Model/NextLvlBase.php` with your database credentials:
     ```php
     $host = 'localhost';
     $user = 'root';
     $password = '';
     $database = 'next_level_sports';
     ```

4. **Start XAMPP services**
   - Start Apache and MySQL from XAMPP Control Panel

5. **Access the application**
   - Open your browser and navigate to:
     ```
     http://localhost/EJERCICIOS/Interficies/Vista/index.php
     ```

## 🚀 Usage

### For Fans
1. Navigate to the home page
2. Click "Registrarse" (Register) → Select "AFICIONADO"
3. Fill in your details and favorite sport
4. Browse events and purchase tickets
5. Check out news and highlights

### For Promoters
1. Navigate to the home page
2. Click "Registrarse" (Register) → Select "PROMOTOR"
3. Complete the registration with your business details
4. Create new events from your profile
5. Publish news updates
6. Manage ticket sales

## 👥 User Roles

### Aficionado (Fan)
- Browse events and news
- Purchase tickets
- View highlights and videos
- Manage personal profile
- Track favorite sports

### Promotor (Promoter)
- Create and manage events
- Publish news articles
- Manage ticket inventory
- Process payments
- View event statistics

## 🗄️ Database

The database schema is defined in `Model/Bd.sql`. It includes tables for:
- Users (fans and promoters)
- Events
- Tickets
- News articles
- User preferences

**Key Models:**
- `NextLvlBase.php` - Base database connection class
- `Aficionado.php` - Fan user class
- `Promotor.php` - Promoter user class

### Database Connection

The application uses MySQL for data persistence. Ensure your credentials are correctly configured in `Model/NextLvlBase.php`.

## 📄 Main Pages

| Page | Route | Purpose |
|------|-------|---------|
| Home | `index.php` | Landing page with featured events |
| Events | `events/general-events.php` | Browse all sporting events |
| News | `news.php` | Latest sports news |
| Highlights | `highligths.php` | Video galleries of best moments |
| Login | `role-selection2.php` → login pages | User authentication |
| Registration | `role-selection.php` | New user signup |
| Profile | `profile.php` | User account dashboard |
| Tickets | `purchase/*.php` | Ticket purchase page |

## 🎨 Styling

All CSS files are located in the `css/` directory:
- `styles.css` - Main stylesheet
- `index.css` - Homepage styles
- `gallery.css` - Highlights gallery
- `news.css` - News pages
- `incoming.css` - Upcoming events
- `role-selection.css` - Registration flow

## 🔒 Security Features

- Password hashing for user accounts
- Form validation on both client and server
- Secure payment form field masking
- SQL injection prevention through prepared statements
- Session-based authentication

## 🌾 Supported Sports

- Football (Fútbol)
- Basketball (Baloncesto)
- Tennis (Tenis)
- Formula 1 (F1)
- MotoGP
- Cycling (Ciclismo)
- Swimming (Natación)
- Athletics (Atletismo)
- And more...

## 📱 Asset Organization

- **Images**: `assets/images/` - Event posters and promotional images
- **Videos**: `assets/videos/` - Promotional and highlight videos
- **Audio**: `assets/audio/` - Audio descriptions for accessibility

## ♿ Accessibility

The platform follows WCAG 2.1 AAA accessibility standards:
- Semantic HTML structure
- ARIA labels for screen readers
- Audio descriptions for visual content
- Keyboard navigation support
- High contrast visuals

## 🤝 Contributing

Contributions are welcome! Please:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Code Style
- Follow PSR-12 PHP coding standards
- Use meaningful variable and function names
- Add comments for complex logic
- Test all changes thoroughly

## 🐛 Known Issues

- Video player compatibility may vary by browser
- Ensure audio files are properly formatted (MP4A support)
- Old browser versions may not support all CSS3 features

## 📝 License

This project is provided as-is for educational and sports event management purposes.

## 👨‍💻 Author

Next Level Sports Development Team

## 📧 Contact & Support

For issues, feature requests, or support:
- Report bugs through GitHub Issues
- See project documentation
- Contact the development team

## 🎯 Future Enhancements

- [ ] Mobile app integration
- [ ] Real-time notifications
- [ ] Social media integration
- [ ] Advanced analytics dashboard
- [ ] Multi-language support
- [ ] Payment gateway integration (Stripe, PayPal)
- [ ] Video streaming integration
- [ ] Rating and review system

## 📊 Statistics

- **Total Events**: 8+ major sporting events
- **News Articles**: 8+ curated stories
- **Supported Sports**: 15+
- **User Types**: 2 (Fans & Promoters)
- **Languages**: Spanish (Main), English ready

---

**Last Updated**: April 2026  
**Version**: 1.0.0  
**Status**: Active Development
