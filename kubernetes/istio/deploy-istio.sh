#!/bin/bash

# Colores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

echo -e "${YELLOW}Iniciando instalación de Istio...${NC}"

# Verificar si istioctl está instalado
if ! command -v istioctl &> /dev/null; then
    echo -e "${RED}istioctl no encontrado. Instalando Istio...${NC}"
    curl -L https://istio.io/downloadIstio | sh -
    cd istio-*
    export PATH=$PWD/bin:$PATH
    cd ..
fi

# Instalar Istio con el perfil demo
echo -e "${YELLOW}Instalando Istio con perfil demo...${NC}"
istioctl install --set profile=demo -y

# Verificar la instalación
if [ $? -eq 0 ]; then
    echo -e "${GREEN}Istio instalado correctamente${NC}"
else
    echo -e "${RED}Error al instalar Istio${NC}"
    exit 1
fi

# Habilitar inyección automática de sidecar en el namespace default
echo -e "${YELLOW}Habilitando inyección automática de sidecar...${NC}"
kubectl label namespace default istio-injection=enabled --overwrite

# Aplicar las configuraciones de Istio
echo -e "${YELLOW}Aplicando configuraciones de Istio...${NC}"
kubectl apply -f gateway.yaml
kubectl apply -f virtualservice.yaml
kubectl apply -f destination-rules.yaml

# Verificar que los recursos se crearon correctamente
echo -e "${YELLOW}Verificando recursos de Istio...${NC}"
kubectl get gateway medical-gateway
kubectl get virtualservice medical-vs
kubectl get destinationrule medical-app appointments-app chatbot-service

# Reiniciar los deployments para que se inyecten los sidecars
echo -e "${YELLOW}Reiniciando deployments para inyección de sidecars...${NC}"
kubectl rollout restart deployment medical-app
kubectl rollout restart deployment appointments-app
kubectl rollout restart deployment chatbot-service

# Esperar a que los pods estén listos
echo -e "${YELLOW}Esperando a que los pods estén listos...${NC}"
kubectl wait --for=condition=ready pod -l app=medical-app --timeout=120s
kubectl wait --for=condition=ready pod -l app=appointments-app --timeout=120s
kubectl wait --for=condition=ready pod -l app=chatbot-service --timeout=120s

# Mostrar estado final
echo -e "${GREEN}Instalación completada${NC}"
echo -e "${YELLOW}Verificando pods:${NC}"
kubectl get pods

# Obtener la IP del Ingress Gateway
echo -e "${YELLOW}Obteniendo IP del Ingress Gateway:${NC}"
kubectl get svc istio-ingressgateway -n istio-system

echo -e "${GREEN}Configuración de Istio completada exitosamente${NC}"