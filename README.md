***Shop***
# Introduce:
A simple product page 

# Install:
- Install Docker Destop from: `https://www.docker.com/products/docker-desktop`
- Run Docker Destop
- Run command: `install`

# Start Server:
- Run command: `alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'`
- Run command: `sail up`

# API Document:
Available in the url: `http://localhost/api/documentation#/`

# Frontend Page:
Available in the url: `http://localhost/product/{product_id}`

# Backend Api:
Login with User: `user/login`
Email: `master@mail.com`
Password: `password`

Upload image with: POST `image/create`
Delete image with: DELETE `image/{image_id}`

Create product with: POST `product/create`
Create product with: PUT `product/{product_id}`
Create product with: DELETE `product/{product_id}`

Database: Mysql
DB_DATABASE=localhost
DB_USERNAME=sail
DB_PORT=3306
DB_PASSWORD=password

File Storage at: `storage\app\public\product`