#!/bin/bash

echo "🚀 Iniciando despliegue en Kubernetes..."

# Asegurar que minikube está corriendo
if ! minikube status &>/dev/null; then
    echo "📦 Iniciando Minikube..."
    minikube start
fi

# Usar el daemon de Docker de Minikube
echo "🔄 Configurando Docker daemon de Minikube..."
eval $(minikube docker-env)

# Construir imágenes
echo "🏗️ Construyendo imágenes Docker..."
docker build -t medical-app:k8s -f kubernetes/dockerfiles/app.Dockerfile .
docker build -t appointments-app:k8s -f kubernetes/dockerfiles/appointments.Dockerfile .
docker build -t chatbot-service:k8s -f kubernetes/dockerfiles/chatbot.Dockerfile .

# Aplicar configuraciones
echo "⚙️ Aplicando configuraciones de Kubernetes..."
kubectl apply -f kubernetes/configs/db-config.yaml
kubectl apply -f kubernetes/configs/app-config.yaml
kubectl apply -f kubernetes/configs/services.yaml
kubectl apply -f kubernetes/configs/services-volumes.yaml
kubectl apply -f kubernetes/configs/medical-app-deployment.yaml

# Esperar a que los pods estén listos
echo "⏳ Esperando a que los pods estén listos..."
kubectl wait --for=condition=ready pod -l app=medical-app --timeout=120s
kubectl wait --for=condition=ready pod -l app=appointments-app --timeout=120s
kubectl wait --for=condition=ready pod -l app=chatbot --timeout=120s

# Mostrar estado
echo "📊 Estado de los servicios:"
kubectl get pods
kubectl get services

# Mostrar URLs de acceso
echo "🌐 URLs de acceso:"
echo "Medical App: $(minikube service medical-app-service --url)"
echo "Appointments: $(minikube service appointments-service --url)"
echo "Chatbot: $(minikube service chatbot-service --url)"

echo "✅ Despliegue completado!"