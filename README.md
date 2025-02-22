# Aplikasi Bank Sampah



1. **Admin**
    - Bisa mengakses semua fitu
2. **Nasabah**
    - Tarik Saldo
3. **Pengepul**
    - Beli Sampah


## Cara Penggunaan

1. **Clone atau Download Repository:**

    ```bash
    git clone https://github.com/arbaap/bank-sampah.git
    ```

2. **Ubah `.env.example` menjadi `.env`**

3. **Konfigurasi DB:**

    - Buka file `.env`
        ```env
        DB_CONNECTION=mysql
   
        DB_DATABASE=namadb
     
        ```

4. **Install Dependencies:**

    ```bash
    composer install
    ```

5. **Generate Application Key:**

    ```bash
    php artisan key:generate
    ```

6. **Create Symbolic Link for Storage:**

    ```bash
    php artisan storage:link
    ```

7. **Run Database Migrations:**

    ```bash
    php artisan migrate
    ```

8. **Seed Database:**

    ```bash
    php artisan db:seed
    ```

9. **Run Artisan Serve:**

    ```bash
    php artisan serve
    ```

10. **Login dengan Akun:**
    - lihat di dbseed atau phpmyadmin
