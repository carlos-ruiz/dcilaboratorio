#! /usr/bin/python
# -*- coding:utf-8 -*-

import os
import binascii
import base64
import random
from M2Crypto import EVP
from datetime import datetime

# Los siguientes valores se emplean aleatoriamente para generar CFDs válidos
DESCRIPCION_PRODUCTOS = ['ESCRITORIO','SILLA','MESA','MANZANA','PERA','LAPICERO','GOMA',
						 'SOFA','MOCHILA','ZAPATOS','GORRA','VINO','BOLETOS','TICKET']
CANTIDADES = ['5.0','15.0','10.0','1.0','2.0','9.0','25.0']
IMPORTES = ['150.00','250.50','25.25','12.50','1850.00','154.51','750.00','1500.00']
IDENTIFICADORES = ['PROD01','PROD02','PROD03','PROD04','PROD05','PROD06','PROD07']
UNIDADES = ['MENSAJE','PIEZA','PKG','REMESA','PIEZAS']
UNITARIOS = ['1530.00','2150.50','225.20','142.50','150.00','54.51','75.00','3000.00']
RFC_RECEPTOR = ["CPA060516BG5","CHO1006237R4","FALG390202EA4","HOAE240126AM0","KAR0606068Z5",
				"TCM970625MB1","UOMA310324LV3","TUCA2107035N9"]
# Lista de emisores de CFDs
RFC_EMISORES = ['AAQM610917QJA','CAMN8004301K0','CAY100623984','ZUN100623663','PZA000413788']

# Función para sellar la cadena original
def selloCFD(stringResult,pemPath):
	#cargar archivo pem
	sat_key=open('%s'%(pemPath),'r').read()
	key=EVP.load_key_string(sat_key)
	#sha1
	key.reset_context(md='sha1')
	key.sign_init()
	#pongo la cadena
	key.sign_update(stringResult)
	signature=key.sign_final()
	#regreso el selloDigital en base64
	return base64.b64encode(signature)

# Función para validar la contraseña de la llave y generar la llave en formato PEM
def validateKeyPass(keyPath,keyPwd,pemPath):
	if os.name=='posix':
		command = 'openssl'
	else:
		command = 'set OPENSSL_CONF=C:\\OpenSSL-Win32\\bin\\openssl.cfg && C:\\OpenSSL-Win32\\bin\\openssl.exe'
	command+= ' pkcs8 -inform der -in "%s" -passin pass:%s -out "%s"' % (str(keyPath),str(keyPwd),str(pemPath))
	f = os.popen(command)
	try:
		f = open('%s' % pemPath,'r')
		key = f.read()
		f.close()
	except:
		key=''
	if key != '':
		errorCode = 0
	else:
		errorCode = 0
	return errorCode

# Función para obtener el número de serie del certificado
def getSerial(cerFile):
	if os.name=='posix':
		command = 'openssl'
	else:
		command = 'set OPENSSL_CONF=C:\\OpenSSL-Win32\\bin\\openssl.cfg && C:\\OpenSSL-Win32\\bin\\openssl.exe'
	command+= ' x509 -inform DER -in "%s" -noout -serial' % cerFile
	f = os.popen(command)
	num_cert = f.read()
	f.close()
	num_cert = num_cert.split("=")
	num_cert = num_cert[1].replace('\n','')
	num_cert = num_cert.replace('\r','')
	num_cert = binascii.unhexlify(num_cert)
	return num_cert

# Función para obtener el certificado en formato PEM para insertarlo en el CFD
def certificadoF(cerFile):
	if os.name=='posix':
		command = 'openssl'
	else:
		command = 'set OPENSSL_CONF=C:\\OpenSSL-Win32\\bin\\openssl.cfg && C:\\OpenSSL-Win32\\bin\\openssl.exe'
#	command+= ' x509 -inform DER -outform PEM -in "%s" -pubkey -out "%s"' % (cerFile,pemCert)
	command+= ' x509 -inform DER -outform PEM -in "%s"' % cerFile
	#f = os.popen(command)
	#f = open(pemCert,'r')
	#codificacion = f.read()
	#f.close()
	codificacion = os.popen(command).read()
	codificacion = codificacion.replace('-----BEGIN CERTIFICATE-----','')
	codificacion = codificacion.replace('-----END CERTIFICATE-----','')
	codificacion = codificacion.replace('\n\r','')
	codificacion = codificacion.replace('\r\n','')
	codificacion = codificacion.replace('\n','')
	codificacion = codificacion.replace('\r','')
	return codificacion

# Función para obtener el RFC a partir del certificado
def getRFC(cerFile):
	if os.name=='posix':
		command = 'openssl'
	else:
		command = 'set OPENSSL_CONF=C:\\OpenSSL-Win32\\bin\\openssl.cfg && C:\\OpenSSL-Win32\\bin\\openssl.exe'
	command+= ' x509 -inform DER -in "%s" -noout -subject -nameopt RFC2253' % cerFile
	f = os.popen(command)
	subject = f.read()
	f.close()
	subject = subject.replace('\n','')
	subject = subject.replace('\r','')
	subject = subject.split(',')
	rfc = subject[2]
	rfc = rfc.split('=')
	rfc = rfc[1].split(' /')
	rfc = rfc[0]
	return rfc

# XSLT para formar la cadena original en la versión 3.2 del Anexo 20 del SAT
if os.name=='posix':
	# Unix like
	xslt = 'xslt/cadenaoriginal_3_2.xslt'
else:
	# Windows
	xslt = 'xslt\\cadenaoriginal_3_2.xslt'

# Procesa todos los RFCs en la lista
for rfc_file in RFC_EMISORES:
	# Determina sistema operativo
	if os.name=='posix':
		# Unix like
		cerFile = '../cert_key/%s.cer' % rfc_file
		keyPath = '../cert_key/%s_s.key' % rfc_file
		keyPwd = '12345678a'
		pemPath = 'tmp/%s_key.pem' % rfc_file
		pemCert = 'tmp/%s_cer.pem' % rfc_file
	else:
		# Windows
		cerFile = '..\\cert_key\\%s.cer' % rfc_file
		keyPath = '..\\cert_key\\%s_s.key' % rfc_file
		keyPwd = '12345678a'
		pemPath = os.getcwd()+'\\tmp\\%s_key.pem' % rfc_file
		pemCert = os.getcwd()+'\\tmp\\%s_cer.pem' % rfc_file
	# Valida contraseña de llave y genera el formato PEM
	errorCode = validateKeyPass(keyPath,keyPwd,pemPath)
	# Obtén número de certificado
	NO_CERTIFICADO = getSerial(cerFile)
	# Obtén certificado en PEM para insertar en CFD
	CERTIFICADO =  certificadoF(cerFile)
	# Obtén rfc a partir del certificado
	RFC_EMISOR = getRFC(cerFile)
	# Fecha y hora actuales
	FECHA = datetime.isoformat(datetime.now())[:19]

	if errorCode == 0:
		# Determina sistema operativo
		if os.name=='posix':
			# Unix like
			xmlResult = 'xml/%s.xml' % rfc_file
		else:
			# Windows
			xmlResult = 'xml\\%s.xml' % rfc_file

		# Lee XML de CFD base
		cfd_xml=open('cfd.xml','r').read()
		# Establece datos de emisor
		cfd_xml = cfd_xml.replace('@CERTIFICADO',CERTIFICADO)
		cfd_xml = cfd_xml.replace('@NO_CERTIFICADO',NO_CERTIFICADO)
		cfd_xml = cfd_xml.replace('@RFC_EMISOR',RFC_EMISOR)
		# Establece fecha de CFD
		cfd_xml = cfd_xml.replace('@FECHA',FECHA)
		# Establece RFC de receptor aleatoriamente
		cfd_xml = cfd_xml.replace('@RFC_RECEPTOR',random.choice(RFC_RECEPTOR))
		# Establece productos aleatoriamente
		cfd_xml = cfd_xml.replace('@DESCRIPCION_PRODUCTO_1',random.choice(DESCRIPCION_PRODUCTOS))
		cfd_xml = cfd_xml.replace('@DESCRIPCION_PRODUCTO_2',random.choice(DESCRIPCION_PRODUCTOS))
		cfd_xml = cfd_xml.replace('@DESCRIPCION_PRODUCTO_3',random.choice(DESCRIPCION_PRODUCTOS))
		# Establece cantidades aleatoriamente
		cfd_xml = cfd_xml.replace('@CANTIDAD_1',random.choice(CANTIDADES))
		cfd_xml = cfd_xml.replace('@CANTIDAD_2',random.choice(CANTIDADES))
		cfd_xml = cfd_xml.replace('@CANTIDAD_3',random.choice(CANTIDADES))
		# Establece importes aleatoriamente
		cfd_xml = cfd_xml.replace('@IMPORTE_1',random.choice(IMPORTES))
		cfd_xml = cfd_xml.replace('@IMPORTE_2',random.choice(IMPORTES))
		cfd_xml = cfd_xml.replace('@IMPORTE_3',random.choice(IMPORTES))
		# Establece identificadores aleatoriamente
		cfd_xml = cfd_xml.replace('@IDENTIFICADOR_1',random.choice(IDENTIFICADORES))
		cfd_xml = cfd_xml.replace('@IDENTIFICADOR_2',random.choice(IDENTIFICADORES))
		cfd_xml = cfd_xml.replace('@IDENTIFICADOR_3',random.choice(IDENTIFICADORES))
		# Establece unidades aleatoriamente
		cfd_xml = cfd_xml.replace('@UNIDAD_1',random.choice(UNIDADES))
		cfd_xml = cfd_xml.replace('@UNIDAD_2',random.choice(UNIDADES))
		cfd_xml = cfd_xml.replace('@UNIDAD_3',random.choice(UNIDADES))
		# Establece precios unitarios aleatoriamente
		cfd_xml = cfd_xml.replace('@UNITARIO_1',random.choice(UNITARIOS))
		cfd_xml = cfd_xml.replace('@UNITARIO_2',random.choice(UNITARIOS))
		cfd_xml = cfd_xml.replace('@UNITARIO_3',random.choice(UNITARIOS))
		# Elimina saltods de línea
		cfd_xml = cfd_xml.replace('\n\r','')
		cfd_xml = cfd_xml.replace('\r\n','')
		cfd_xml = cfd_xml.replace('\n','')
		cfd_xml = cfd_xml.replace('\r','')
		# Guarda XML
		open('%s' % xmlResult,'w').write('%s' % cfd_xml)
		# Obtén cadena original
		if os.name=='posix':
			# Unix like
			stringResult=os.popen("xsltproc %s %s 2>/dev/null" % (xslt,xmlResult)).read()
		else:
			# Windows
			stringResult=os.popen("msxsl.exe %s %s" % (xmlResult,xslt)).read()
		# Crea sello
		SELLO = selloCFD(stringResult,pemPath)
		# Incluye sello 
		cfd_xml = cfd_xml.replace('@SELLO',SELLO)
		# Guarda XML con sello
		open('%s' % xmlResult,'w').write('%s' % cfd_xml)
		# Imprime resultado de procesamiento
		print 'CADENA ORIGINAL = %s' % stringResult
		print 'NO CERTIFICADO = %s' % NO_CERTIFICADO
		print 'SELLO = %s' % SELLO
		print 'RFC EMISOR = %s' % RFC_EMISOR
		print '*'*50
	else:
		print "Error, no coincide contraseña con llave privada"
