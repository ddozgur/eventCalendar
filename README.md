


## **Kurulum**

Proje ortamını yerel makinede çalıştırmak için aşağıdaki adımları takip edebilirsiniz:

1. **Depoyu klonlayın:**  
   ```bash
   git clone https://github.com/ddozgur/eventCalendar.git
   cd eventCalendar
   ```

2. **Gerekli bağımlılıkları yükleyin:**  
   ```bash
   composer install
   ```

3. **Ortam değişkenlerini ayarlayın:**  
   `.env` dosyasını oluşturun ve veritabanı bilgilerini girin. Örnek bir `.env` dosyası:  
   ```env

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=event_calendar
   DB_USERNAME=root
   DB_PASSWORD=  
   
   ```

4. **Veritabanı tablolarını oluşturun:**  
   ```bash
   php artisan migrate
   ```

5. **Seed Verilerini Yükleyin:**  
   ```bash
   php artisan db:seed --class=UserSeeder
   ```

6. **Uygulamayı başlatın:**  
   ```bash
   php artisan serve
   ```

---

