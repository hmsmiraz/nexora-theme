# Nexora WordPress — Complete Deployment Guide

> **Project:** Nexora — A custom WordPress landing page theme  
> **Author:** hmsmiraz  
> **GitHub:** https://github.com/hmsmiraz/nexora-theme  
> **Docker Hub:** https://hub.docker.com/r/hmsmiraz/nexora-wordpress  
> **Stack:** WordPress · MySQL · Docker · Kubernetes (EKS) · AWS EC2

---

## Table of Contents

1. [Project Overview](#1-project-overview)
2. [Project Structure](#2-project-structure)
3. [Prerequisites](#3-prerequisites)
4. [Phase 1 — Local WordPress Theme Development](#4-phase-1--local-wordpress-theme-development)
5. [Phase 2 — Dockerize the Application](#5-phase-2--dockerize-the-application)
6. [Phase 3 — Run with Docker Compose on EC2](#6-phase-3--run-with-docker-compose-on-ec2)
7. [Phase 4 — Push to Docker Hub](#7-phase-4--push-to-docker-hub)
8. [Phase 5 — Deploy to AWS EKS (Kubernetes)](#8-phase-5--deploy-to-aws-eks-kubernetes)
9. [Troubleshooting](#9-troubleshooting)
10. [Useful Commands Reference](#10-useful-commands-reference)

---

## 1. Project Overview

**Nexora** is a modern, dark-themed WordPress landing page theme built for businesses, agencies, and creators. It is fully containerized with Docker and deployed on AWS EKS (Elastic Kubernetes Service).

# Nexora WordPress Theme

A modern, high-performance WordPress landing page theme.

## Installation

1. Upload the `nexora-theme` folder to `/wp-content/themes/`
2. Go to **Appearance → Themes** and activate **Nexora**
3. Go to **Settings → Reading** → set "Your homepage displays" to **A static page** → choose any page as Homepage
4. The landing page (`front-page.php`) will now display automatically

## Customization

All text content is editable via **Appearance → Customize**:
- **Hero Section** — badge, headline, subtitle, buttons, stats
- **CTA Section** — heading, subtitle, button labels
- **Footer** — description, copyright text

## Managing Content via WordPress Admin

### Features (6 cards)
Go to **Features** in the admin menu → Add New Feature
- **Title** = feature heading
- **Content** = description text
- Add a custom field `_feature_icon` with an emoji value (e.g. `🎨`)

### Testimonials
Go to **Testimonials** → Add New Testimonial
- **Title** = person's name
- **Content** = testimonial text
- Custom fields: `_testi_name`, `_testi_role`

### Pricing Plans
Go to **Pricing Plans** → Add New Plan
- Custom fields:
  - `_pricing_price` — number (e.g. `29`)
  - `_pricing_period` — text (e.g. `per month, billed annually`)
  - `_pricing_featured` — `1` for highlighted plan
  - `_pricing_features` — one feature per line
  - `_pricing_btn_text` — button label
  - `_pricing_btn_style` — `primary` or `ghost`

## Theme Files

```
nexora-theme/
├── style.css           ← Required theme header
├── functions.php       ← Theme setup, enqueue, CPTs, Customizer
├── index.php           ← Fallback template
├── front-page.php      ← Main landing page template
├── header.php          ← <head>, nav
├── footer.php          ← footer, wp_footer()
└── assets/
    ├── css/main.css    ← All styles
    └── js/main.js      ← Smooth scroll, mobile nav, scroll reveal
```

## Requirements
- WordPress 6.0+
- PHP 7.4+


### What was built

- A custom WordPress theme (`nexora-theme`) with:
  - Sticky navigation bar with blur effect
  - Hero section with animated badge, stats, and CTA buttons
  - Scrolling marquee banner
  - Features grid (6 cards with hover effects)
  - How it works section with mock browser preview
  - Testimonials section
  - 3-tier pricing section (Starter / Pro / Agency)
  - CTA section and full footer
  - Fully responsive (mobile-first)
  - WordPress Customizer support for all text content
  - Custom Post Types: Features, Testimonials, Pricing Plans

### Tech Stack

| Layer | Technology |
|---|---|
| CMS | WordPress 6.x |
| Database | MySQL 8.0 |
| Web Server | Apache 2.4 (inside container) |
| Containerization | Docker + Docker Compose |
| Container Registry | Docker Hub |
| Cloud | AWS EC2 (Ubuntu 22.04) |
| Orchestration | AWS EKS (Kubernetes) |
| Storage | AWS EBS (via EBS CSI Driver) |
| Load Balancer | AWS ELB (provisioned by Kubernetes) |

---

## 2. Project Structure

```
nexora-theme/               ← WordPress theme (GitHub repo)
├── style.css               ← Required theme header
├── functions.php           ← Enqueue assets, CPTs, Customizer
├── index.php               ← Fallback template
├── front-page.php          ← Main landing page template
├── header.php              ← Nav bar
├── footer.php              ← Footer
└── assets/
    ├── css/main.css        ← All styles
    └── js/main.js          ← Smooth scroll, mobile nav, animations

nexora-docker/              ← Docker setup (on EC2)
├── Dockerfile              ← Ubuntu + Apache + PHP + WordPress + theme
├── docker-compose.yml      ← WordPress + MySQL services
├── wp-config.php           ← WordPress database config
└── wordpress.conf          ← Apache virtual host config

nexora-k8s/                 ← Kubernetes manifests (on EC2)
├── mysql-secret.yaml       ← DB credentials as K8s Secret
├── mysql-deployment.yaml   ← MySQL Deployment + PVC + Service
└── wordpress-deployment.yaml ← WordPress Deployment + Service (LoadBalancer)
```

---

## 3. Prerequisites

- AWS Account with IAM user (AdministratorAccess)
- EC2 instance: **Ubuntu 22.04**, instance type **m7i-flex.large**, 25 GB EBS
- Key pair `.pem` file for SSH
- Docker Hub account (username: `hmsmiraz`)
- GitHub account

---

## 4. Phase 1 — Local WordPress Theme Development

The Nexora theme was developed as a standard WordPress theme with the following key files:

### style.css (required theme header)
```css
/*
Theme Name: Nexora
Version: 1.0.0
Description: Modern dark landing page theme for WordPress
Text Domain: nexora
*/
```

### functions.php highlights
- Enqueues Google Fonts (Syne + DM Sans), main CSS, and JS
- Registers Primary and Footer nav menus
- Adds WordPress Customizer sections for Hero, CTA, and Footer
- Registers 3 Custom Post Types: `nexora_feature`, `nexora_testimonial`, `nexora_pricing`
- Helper functions: `nexora_get_features()`, `nexora_get_testimonials()`, `nexora_get_pricing()`

### front-page.php
Renders all landing page sections using WordPress template tags and Customizer values. Falls back to hardcoded defaults if no CPT posts exist.

### To run locally (quick preview)
```bash
# Option 1: Open directly in browser
# Double-click the HTML file — works instantly

# Option 2: Python local server
python -m http.server 8080
# Visit: http://localhost:8080

# Option 3: VS Code Live Server extension
# Install Live Server → click "Go Live" in bottom bar
```

### To install in WordPress locally
1. Install [LocalWP](https://localwp.com/)
2. Create a new site
3. Copy `nexora-theme/` to `wp-content/themes/`
4. Activate under **Appearance → Themes**
5. Set static homepage: **Settings → Reading → Static Page**

---

## 5. Phase 2 — Dockerize the Application

### SSH into EC2

```bash
ssh -i your-key.pem ubuntu@YOUR_IP
```

### Install Docker

```bash
# Remove old docker
sudo apt remove docker docker-engine docker.io containerd runc -y

# Add Docker repo
sudo apt update
sudo apt install ca-certificates curl gnupg lsb-release -y
sudo mkdir -p /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg
echo "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] \
  https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" | \
  sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

# Install Docker + Compose
sudo apt remove docker-compose-v2 -y
sudo dpkg --configure -a
sudo apt --fix-broken install -y
sudo apt update
sudo apt install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin -y

# Start and enable
sudo systemctl start docker
sudo systemctl enable docker
sudo usermod -aG docker ubuntu
newgrp docker
```

### Create project folder

```bash
mkdir ~/nexora-docker && cd ~/nexora-docker
```

### Dockerfile

```dockerfile
FROM ubuntu:22.04
ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y \
    apache2 php php-mysql php-curl php-gd \
    php-mbstring php-xml php-zip wget unzip git \
    && rm -rf /var/lib/apt/lists/*

# Download WordPress
RUN wget -q https://wordpress.org/latest.tar.gz -O /tmp/wordpress.tar.gz \
    && tar -xzf /tmp/wordpress.tar.gz -C /var/www/html/ \
    && rm /tmp/wordpress.tar.gz

# Clone Nexora theme from GitHub
RUN git clone https://github.com/hmsmiraz/nexora-theme.git \
    /var/www/html/wordpress/wp-content/themes/nexora-theme

COPY wp-config.php /var/www/html/wordpress/wp-config.php
COPY wordpress.conf /etc/apache2/sites-available/wordpress.conf

RUN a2ensite wordpress.conf \
    && a2dissite 000-default.conf \
    && a2enmod rewrite

RUN chown -R www-data:www-data /var/www/html/wordpress

EXPOSE 80
CMD ["apachectl", "-D", "FOREGROUND"]
```

### wp-config.php

```php
<?php
define( 'DB_NAME',     'wordpress' );
define( 'DB_USER',     'wpuser' );
define( 'DB_PASSWORD', 'StrongPass123!' );
define( 'DB_HOST',     'db' );          // 'db' = docker-compose service name
define( 'DB_CHARSET',  'utf8' );
$table_prefix = 'wp_';
define( 'WP_DEBUG', false );
if ( ! defined( 'ABSPATH' ) ) define( 'ABSPATH', __DIR__ . '/' );
require_once ABSPATH . 'wp-settings.php';
```

### wordpress.conf (Apache virtual host)

```apache
<VirtualHost *:80>
    DocumentRoot /var/www/html/wordpress
    <Directory /var/www/html/wordpress>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

---

## 6. Phase 3 — Run with Docker Compose on EC2

### docker-compose.yml

```yaml
version: '3.8'
services:
  db:
    image: mysql:8.0
    container_name: nexora_db
    restart: always
    environment:
      MYSQL_DATABASE: wordpress
      MYSQL_USER: wpuser
      MYSQL_PASSWORD: StrongPass123!
      MYSQL_ROOT_PASSWORD: RootPass123!
    volumes:
      - db_data:/var/lib/mysql

  wordpress:
    build: .
    container_name: nexora_wordpress
    restart: always
    ports:
      - "8080:80"        # changed from 80 to 8080 (Apache used port 80)
    depends_on:
      - db
    volumes:
      - wp_data:/var/www/html/wordpress/wp-content

volumes:
  db_data:
  wp_data:
```

> **Note:** Port was changed to `8080` because Apache was already using port `80` on the host EC2 instance.

### Stop host Apache (to free port 80 if needed)

```bash
sudo systemctl stop apache2
sudo systemctl disable apache2
```

### Build and run

```bash
cd ~/nexora-docker
docker compose up -d --build
```

### Verify containers

```bash
docker ps
# Should show nexora_db and nexora_wordpress both Up
```

### Open port 8080 in AWS Security Group

Go to **EC2 → Security Groups → Inbound Rules → Add Rule:**

| Type | Port | Source |
|------|------|--------|
| Custom TCP | 8080 | 0.0.0.0/0 |

### Visit site

```
http://YOUR_IP:8080
```

Complete the WordPress setup wizard, then activate the Nexora theme.

---

## 7. Phase 4 — Push to Docker Hub

```bash
# Login
docker login
# Username: hmsmiraz

# Build with Docker Hub tag
docker build -t hmsmiraz/nexora-wordpress:latest ~/nexora-docker/

# Push
docker push hmsmiraz/nexora-wordpress:latest

# Optional: tag with version
docker tag hmsmiraz/nexora-wordpress:latest hmsmiraz/nexora-wordpress:v1.0
docker push hmsmiraz/nexora-wordpress:v1.0
```

Image available at: `docker.io/hmsmiraz/nexora-wordpress:latest`

---

## 8. Phase 5 — Deploy to AWS EKS (Kubernetes)

### Install kubectl

```bash
curl -LO "https://dl.k8s.io/release/$(curl -L -s https://dl.k8s.io/release/stable.txt)/bin/linux/amd64/kubectl"
sudo install -o root -g root -m 0755 kubectl /usr/local/bin/kubectl
kubectl version --client
```

### Install eksctl

```bash
curl -sLO "https://github.com/eksctl-io/eksctl/releases/latest/download/eksctl_Linux_amd64.tar.gz"
tar -xzf eksctl_Linux_amd64.tar.gz
sudo mv eksctl /usr/local/bin
eksctl version
```

### Install AWS CLI

```bash
curl "https://awscli.amazonaws.com/awscli-exe-linux-x86_64.zip" -o "awscliv2.zip"
unzip awscliv2.zip
sudo ./aws/install
aws --version
```

### Configure AWS credentials

```bash
aws configure
# AWS Access Key ID: YOUR_KEY
# AWS Secret Access Key: YOUR_SECRET
# Default region: ap-south-1
# Output format: json
```

### Create EKS cluster

```bash
eksctl create cluster \
  --name nexora-cluster \
  --region ap-south-1 \
  --nodegroup-name nexora-workers \
  --node-type m7i-flex.large \
  --nodes 1 \
  --nodes-min 1 \
  --nodes-max 1 \
  --managed
```

> Takes 10–15 minutes. EKS manages the control plane automatically.

### Verify cluster

```bash
kubectl get nodes
# NAME                                          STATUS   ROLES    AGE
# ip-192-168-26-167.ap-south-1.compute.internal Ready   <none>   2m
```

### Install EBS CSI Driver (required for storage)

Without this, PersistentVolumeClaims stay Pending and pods never start.

```bash
# Associate OIDC provider
eksctl utils associate-iam-oidc-provider \
  --region ap-south-1 \
  --cluster nexora-cluster \
  --approve

# Create IAM service account
eksctl create iamserviceaccount \
  --name ebs-csi-controller-sa \
  --namespace kube-system \
  --cluster nexora-cluster \
  --region ap-south-1 \
  --attach-policy-arn arn:aws:iam::aws:policy/service-role/AmazonEBSCSIDriverPolicy \
  --approve \
  --override-existing-serviceaccounts

# Install EBS CSI addon
eksctl create addon \
  --name aws-ebs-csi-driver \
  --cluster nexora-cluster \
  --region ap-south-1 \
  --force

# Verify
kubectl get pods -n kube-system | grep ebs
```

### Create namespace

```bash
kubectl create namespace nexora
kubectl get namespaces
```

### Create Kubernetes manifests

```bash
mkdir ~/nexora-k8s && cd ~/nexora-k8s
```

#### mysql-secret.yaml

```yaml
apiVersion: v1
kind: Secret
metadata:
  name: mysql-secret
  namespace: nexora
type: Opaque
stringData:
  mysql-root-password: RootPass123!
  mysql-password: StrongPass123!
  mysql-user: wpuser
  mysql-database: wordpress
```

#### mysql-deployment.yaml

```yaml
apiVersion: v1
kind: PersistentVolumeClaim
metadata:
  name: mysql-pvc
  namespace: nexora
spec:
  accessModes:
    - ReadWriteOnce
  storageClassName: gp2
  resources:
    requests:
      storage: 5Gi
---
apiVersion: apps/v1
kind: Deployment
metadata:
  name: mysql
  namespace: nexora
spec:
  replicas: 1
  selector:
    matchLabels:
      app: mysql
  template:
    metadata:
      labels:
        app: mysql
    spec:
      containers:
        - name: mysql
          image: mysql:8.0
          env:
            - name: MYSQL_ROOT_PASSWORD
              valueFrom:
                secretKeyRef:
                  name: mysql-secret
                  key: mysql-root-password
            - name: MYSQL_DATABASE
              valueFrom:
                secretKeyRef:
                  name: mysql-secret
                  key: mysql-database
            - name: MYSQL_USER
              valueFrom:
                secretKeyRef:
                  name: mysql-secret
                  key: mysql-user
            - name: MYSQL_PASSWORD
              valueFrom:
                secretKeyRef:
                  name: mysql-secret
                  key: mysql-password
          ports:
            - containerPort: 3306
          volumeMounts:
            - name: mysql-storage
              mountPath: /var/lib/mysql
      volumes:
        - name: mysql-storage
          persistentVolumeClaim:
            claimName: mysql-pvc
---
apiVersion: v1
kind: Service
metadata:
  name: db
  namespace: nexora
spec:
  selector:
    app: mysql
  ports:
    - port: 3306
      targetPort: 3306
```

#### wordpress-deployment.yaml

```yaml
apiVersion: apps/v1
kind: Deployment
metadata:
  name: wordpress
  namespace: nexora
spec:
  replicas: 1
  selector:
    matchLabels:
      app: wordpress
  template:
    metadata:
      labels:
        app: wordpress
    spec:
      containers:
        - name: wordpress
          image: hmsmiraz/nexora-wordpress:latest
          env:
            - name: WORDPRESS_DB_HOST
              value: db:3306
            - name: WORDPRESS_DB_NAME
              valueFrom:
                secretKeyRef:
                  name: mysql-secret
                  key: mysql-database
            - name: WORDPRESS_DB_USER
              valueFrom:
                secretKeyRef:
                  name: mysql-secret
                  key: mysql-user
            - name: WORDPRESS_DB_PASSWORD
              valueFrom:
                secretKeyRef:
                  name: mysql-secret
                  key: mysql-password
          ports:
            - containerPort: 80
---
apiVersion: v1
kind: Service
metadata:
  name: wordpress-service
  namespace: nexora
spec:
  selector:
    app: wordpress
  type: LoadBalancer
  ports:
    - protocol: TCP
      port: 80
      targetPort: 80
```

> **Note:** The `volumeMounts` for wp-content was removed because mounting a PVC over that path overwrites the theme files baked into the Docker image.

### Deploy everything

```bash
kubectl apply -f mysql-secret.yaml
kubectl apply -f mysql-deployment.yaml
kubectl apply -f wordpress-deployment.yaml
```

### Verify pods are running

```bash
kubectl get pods -n nexora
# NAME                         READY   STATUS    RESTARTS   AGE
# mysql-69ccd97456-4whtp       1/1     Running   0          2m
# wordpress-9b9c57564-fncs2    1/1     Running   0          2m
```

### Get Load Balancer URL

```bash
kubectl get svc wordpress-service -n nexora
# EXTERNAL-IP = xxxxxxxx.ap-south-1.elb.amazonaws.com
```

### Update WordPress site URL in database

Run this if WordPress redirects to an old URL:

```bash
kubectl exec -it <mysql-pod-name> -n nexora -- mysql -u wpuser -pStrongPass123! wordpress
```

```sql
UPDATE wp_options SET option_value = 'http://YOUR-ELB-URL' WHERE option_name = 'siteurl';
UPDATE wp_options SET option_value = 'http://YOUR-ELB-URL' WHERE option_name = 'home';
EXIT;
```

### Open the site

```
http://xxxxxxxx.ap-south-1.elb.amazonaws.com
```

Login at `/wp-admin` → **Appearance → Themes** → Activate **Nexora**

---

## 9. Troubleshooting

### Pods stuck in Pending state
**Cause:** PVCs not bound — EBS CSI driver not installed.
```bash
kubectl get pvc -n nexora
kubectl describe pvc mysql-pvc -n nexora
```
**Fix:** Install EBS CSI driver (see Phase 5) and add `storageClassName: gp2` to PVCs.

### Theme not showing in WordPress admin
**Cause:** PVC volume mounted over `wp-content`, overwriting theme files.
**Fix:** Remove `volumeMounts` from wordpress deployment for the wp-content path.

### "Publishing failed. Not a valid JSON response"
**Cause:** Apache mod_rewrite not enabled or wrong file permissions.
```bash
kubectl exec -it <wordpress-pod> -n nexora -- bash -c 'a2enmod rewrite'
kubectl rollout restart deployment/wordpress -n nexora
```
Then in WP Admin: **Settings → Permalinks → Save**.

### Site redirecting to old Load Balancer URL
**Cause:** WordPress `siteurl` and `home` options point to old ELB.
**Fix:** Update via MySQL (see above).

### "docker-compose: command not found"
```bash
# Use new syntax with space
docker compose up -d --build

# Or install plugin
sudo apt install docker-compose-plugin -y
```

### Port 80 already in use (Docker)
```bash
sudo systemctl stop apache2
sudo systemctl disable apache2
docker compose up -d
```

### EBS CSI driver install conflict
```bash
sudo apt remove docker-compose-v2 -y
sudo dpkg --configure -a
sudo apt --fix-broken install -y
```

---

## 10. Useful Commands Reference

### Docker

```bash
docker ps                              # list running containers
docker compose up -d --build          # build and start
docker compose down                   # stop containers
docker compose logs -f                # view logs
docker exec -it nexora_wordpress bash # enter container
docker build -t hmsmiraz/nexora-wordpress:latest .
docker push hmsmiraz/nexora-wordpress:latest
```

### Kubernetes

```bash
kubectl get pods -n nexora            # list pods
kubectl get pods -n nexora -w         # watch pods live
kubectl get svc -n nexora             # list services
kubectl get pvc -n nexora             # list storage claims
kubectl get nodes                     # list cluster nodes
kubectl describe pod <name> -n nexora # debug a pod
kubectl logs -f deployment/wordpress -n nexora  # view logs
kubectl exec -it <pod> -n nexora -- bash        # enter pod
kubectl rollout restart deployment/wordpress -n nexora
kubectl delete namespace nexora       # delete everything
```

### EKS Cluster

```bash
eksctl get cluster                    # list clusters
eksctl delete cluster --name nexora-cluster --region ap-south-1
```

### AWS

```bash
aws configure                         # set credentials
aws eks update-kubeconfig --name nexora-cluster --region ap-south-1
```

---

## Architecture Diagram

```
                        Internet
                            |
                    AWS Load Balancer (ELB)
                            |
                    ┌───────────────┐
                    │  EKS Cluster  │
                    │  (ap-south-1) │
                    │               │
                    │  Namespace:   │
                    │   nexora      │
                    │               │
                    │  ┌─────────┐  │
                    │  │WordPress│  │
                    │  │  Pod    │  │
                    │  │(Apache) │  │
                    │  └────┬────┘  │
                    │       │       │
                    │  ┌────▼────┐  │
                    │  │ MySQL   │  │
                    │  │  Pod    │  │
                    │  └────┬────┘  │
                    │       │       │
                    │  ┌────▼────┐  │
                    │  │AWS EBS  │  │
                    │  │(gp2 PVC)│  │
                    │  └─────────┘  │
                    └───────────────┘
```

---

*Built and deployed by hmsmiraz — May 2026*