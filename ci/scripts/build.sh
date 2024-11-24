#!/bin/bash

echo "Building Docker images..."

# Define services
SERVICES=("app" "appointments-app" "chatbot-service")

# Build each service
for SERVICE in "${SERVICES[@]}"
do
    echo "Building $SERVICE..."
    docker compose -f docker-compose.yml build $SERVICE
done

echo "Build completed successfully!"
