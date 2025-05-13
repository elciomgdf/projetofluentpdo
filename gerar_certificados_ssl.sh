#!/bin/bash

CERT_DIR="./docker/ssl"
CONFIG_FILE="./docker/ssl/openssl-san.cnf"
mkdir -p $CERT_DIR

# Cria um arquivo de configuração openssl com SAN
cat > $CONFIG_FILE <<EOL
[req]
default_bits       = 2048
distinguished_name = req_distinguished_name
req_extensions     = req_ext
x509_extensions    = v3_ca
prompt             = no

[req_distinguished_name]
C  = BR
ST = Estado
L  = Cidade
O  = Empresa
CN = projetofluentpdo.test

[req_ext]
subjectAltName = @alt_names

[v3_ca]
subjectAltName = @alt_names
basicConstraints = critical, CA:TRUE
keyUsage = critical, digitalSignature, cRLSign, keyCertSign

[alt_names]
DNS.1 = projetofluentpdo.test
DNS.2 = projetomedoo.test
EOL

# Gera o certificado com SAN
openssl req -x509 -nodes -days 365 \
    -newkey rsa:2048 \
    -keyout $CERT_DIR/key.pem \
    -out $CERT_DIR/cert.pem \
    -config $CONFIG_FILE \
    -extensions v3_ca

echo "Certificado gerado com SAN para projetofluentpdo.test e projetomedoo.test:"
ls -l $CERT_DIR
