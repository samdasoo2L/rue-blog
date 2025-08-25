# 베이스 이미지 설정 반드시 최상단에 위치
FROM php:8.2-fpm

# RUN : 이미지를 만들 때 이 명령어를 실행하여 결과를 저장, 이 결과가 이미지 레이어로 저장됨
# 필요한 패키지 설치
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && docker-php-ext-enable pdo_mysql mbstring exif pcntl bcmath gd zip

# Composer 설치
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 작업 디렉토리 설정
WORKDIR /var/www/html

# 애플리케이션 파일 복사
COPY . /var/www/html

# 권한 설정
# 한줄로 묶으면 이미지 작아지고 빨라진다. 하지만 디버깅 어려워진다.
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Git에 safe directory 설정 추가 + Composer 의존성 설치
RUN git config --global --add safe.directory '*' \
    && composer install --no-interaction --optimize-autoloader

# 포트 노출
EXPOSE 9000

# PHP-FPM 시작
CMD ["php-fpm"]
