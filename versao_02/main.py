import time
from pycep_correios import get_address_from_cep, WebService, exceptions
from openpyxl import Workbook, load_workbook

tempo_inicial = time.time()

# carregamos o arquivo excel
planilha = load_workbook('CEP_reduzido.xlsx')
aba_ativa = planilha.active

array_cep = []

for celula in aba_ativa['D']:
    array_cep.append(celula.value)


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

    if len(str(cep)) != 8:
        erro_caracteres += 1
        cep_qnt_invalida.append(cep)

    try:
        endereco = get_address_from_cep(str(cep), webservice=WebService.CORREIOS)
        print(f'Lido: {cep} - Cidade: {endereco["cidade"]}')

    except exceptions.InvalidCEP:
        ceps_inexistentes.append(cep)

    except exceptions.CEPNotFound:
        ceps_inexistentes.append(cep)
        counter += 1

    except exceptions.ConnectionError as errc:
        print(f'Erro de conexão com o servidor dos correios: {errc}')

    except exceptions.Timeout as errt:
        print(f'Erro de timeout: {errt}')

    except exceptions.HTTPError as errh:
        print(f'Erro de HTTPt: {errt}')

    except exceptions.BaseException as e:
        ceps_inexistentes.append(cep)
        counter += 1



print('*' * 30)
print(f'CEPs com caracteres inválidos: {erro_caracteres}')
print(f'LISTA de CEPs com quantidade de caracteres incorretos: {cep_qnt_invalida}')
print('*' * 30)
print(f'A quantidade de CEPs não encontrados no WebService foi de: {counter}')
print(f'LISTA de CEPs inexistentes no WebService: {ceps_inexistentes}')
print('*' * 30)
print("--- Tempo de execução: %s segundos ---" % (time.time() - tempo_inicial))



