#!/bin/bash

echo "Rue Blog 배포를 시작합니다..."

# 프로젝트 디렉토리로 이동
cd /home/ubuntu/rue-blog

# Git에서 최신 코드 가져오기
echo "최신 코드를 가져옵니다..."
git pull origin main

# 기존 컨테이너 중지
echo "기존 컨테이너를 중지합니다..."
docker-compose down

# 새 컨테이너 빌드 및 시작
echo "새 컨테이너를 빌드하고 시작합니다..."
docker-compose up -d --build

# 데이터베이스 마이그레이션
echo "데이터베이스 마이그레이션을 실행합니다..."
docker-compose exec -T app php artisan migrate --force

# 캐시 정리
echo "캐시를 정리합니다..."
docker-compose exec -T app php artisan config:cache
docker-compose exec -T app php artisan route:cache
docker-compose exec -T app php artisan view:cache

# 권한 설정
echo "권한을 설정합니다..."
docker-compose exec -T app chown -R www-data:www-data storage bootstrap/cache
docker-compose exec -T app chmod -R 775 storage bootstrap/cache

echo "배포가 완료되었습니다!"
echo "웹 애플리케이션: http://$(curl -s ifconfig.me)"

