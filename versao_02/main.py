import xlrd
import numpy as np
import time
from pycep_correios import get_address_from_cep, WebService, exceptions

tempo_inicial = time.time()

wb = xlrd.open_workbook('CEP_500.xlsx')
p = wb.sheet_by_name('Lista')
lin = p.nrows
array_cep = np.zeros(lin)

for i in range(lin):
    array_cep[i] = p.cell(i, 3).value

#=============================================

print("=" * 80)
print("===========>> Iniciando consultas - Aguarde")
print("=" * 80)

counter = 0
erro_caracteres = 0
ceps_inexistentes = []
cep_qnt_invalida = []

'''
Percorre a lista com os CEPs faz a requisição e valida se existe todos os CEPs válidos.
'''
for cep in array_cep:
    cep_ok = int(cep)
    if len(str(cep_ok)) != 8:
        erro_caracteres += 1
        cep_qnt_invalida.append(cep_ok)

    try:
        endereco = get_address_from_cep(str(cep_ok), webservice=WebService.CORREIOS)

    except exceptions.InvalidCEP:
        ceps_inexistentes.append(cep_ok)

    except exceptions.CEPNotFound:
        ceps_inexistentes.append(cep_ok)
        counter += 1

    except exceptions.ConnectionError as errc:
        print(f'Erro de conexão com o servidor dos correios: {errc}')

    except exceptions.Timeout as errt:
        print(f'Erro de timeout: {errt}')

    except exceptions.HTTPError as errh:
        print(f'Erro de HTTPt: {errt}')

    except exceptions.BaseException as e:
        ceps_inexistentes.append(cep_ok)
        counter += 1



print('*' * 30)
print(f'CEPs com caracteres inválidos: {erro_caracteres}')
print(f'LISTA de CEPs com quantidade de caracteres incorretos: {cep_qnt_invalida}')
print('*' * 30)
print(f'A quantidade de CEPs não encontrados no WebService foi de: {counter}')
print(f'LISTA de CEPs inexistentes no WebService: {ceps_inexistentes}')
print('*' * 30)
print("--- Tempo de execução: %s segundos ---" % (time.time() - tempo_inicial))



