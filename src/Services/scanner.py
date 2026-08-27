#pip install opencv-python pyzbar

import cv2
from pyzbar.pyzbar import decode

cap = cv2.VideoCapture(0)  # 0 = webcam padrão

codigos_lidos = set()  # evita imprimir o mesmo código repetidas vezes
encontrado = False
codigo_peca = None

while True:
    ret, frame = cap.read()
    if not ret:
        break

    resultados = decode(frame)
    for r in resultados:
        codigo = r.data.decode('utf-8')
        
        # desenha um retângulo ao redor do código detectado
        (x, y, w, h) = r.rect
        cv2.rectangle(frame, (x, y), (x + w, y + h), (0, 255, 0), 2)
        cv2.putText(frame, codigo, (x, y - 10), 
                    cv2.FONT_HERSHEY_SIMPLEX, 0.6, (0, 255, 0), 2)

        if codigo not in codigos_lidos:
            codigos_lidos.add(codigo)
            codigo_peca = codigo
            print(f"Código lido: {codigo} (tipo: {r.type})")
            
        encontrado = True
        
    cv2.imshow('Scanner - pressione Q para sair', frame)

    if cv2.waitKey(1) & 0xFF == ord('q') or encontrado == True:
        print(f"Código tesrteee lido: {codigo_peca} (tipo: {r.type})")
        break

cap.release()
cv2.destroyAllWindows()