# FurniCasa Laravel Website — Setup (हिंदी)

इस ZIP में Laravel PHP website और अलग admin panel का source code है। Website चलाने के लिए आपके computer या hosting server पर PHP 8.2+, Composer, Node.js/npm और SQLite/MySQL ज़रूरी हैं।

## Steps

1. ZIP को extract करें और project folder को VS Code में खोलें।
2. Terminal में `composer install` चलाएँ।
3. `.env.example` का नाम `.env` करके copy करें और `php artisan key:generate` चलाएँ।
4. `.env` में अपना `ADMIN_EMAIL` और कम से कम 12 characters का अपना `ADMIN_PASSWORD` भरें। किसी को admin password share न करें।
5. SQLite उपयोग कर रहे हैं, तो `database/database.sqlite` नाम की empty file बनाएं। MySQL इस्तेमाल करना हो तो `.env` में MySQL settings भरें।
6. ये commands चलाएँ:

```bash
php artisan migrate --seed
php artisan storage:link
npm install
npm run build
php artisan serve
```

7. Browser में `http://127.0.0.1:8000` पर website और `http://127.0.0.1:8000/admin` पर admin panel खुलेगा। Admin login वही होगा जो `.env` में set किया है।

### Admin panel में क्या मिलेगा?

Products, categories, stock adjustment, stock movement history, orders, coupons, customers, review moderation, messages, subscribers और settings.

### महत्वपूर्ण

Sample products और photos **demo** हैं। Online card payments अभी connected नहीं हैं; COD और manual bank transfer available हैं। Real business के लिए domain/hosting, gateway, actual photos, shipping rules, legal pages और security testing बाकी होंगे।
