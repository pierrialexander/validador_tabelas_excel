import time
import ValidacoesCep
#from pycep_correios import get_address_from_cep, WebService, exceptions
import pandas as pd
from openpyxl import Workbook, load_workbook

tempo_inicial = time.time()
#====================================
# carregamos o arquivo excel
planilha = load_workbook('Arquivos/CEP.xlsx')
aba_ativa = planilha.active

array_cep = []

for celula in aba_ativa['D']:
    array_cep.append(celula.value)

#====================================
# Lê o arquivo e carrega a Base De CEPs
lista_cep = pd.read_excel('Arquivos/Base_de_CEPs.xlsx', usecols=['CEP'])
df = pd.DataFrame(lista_cep)

# Coleta os dados do dataframe e monta uma tupla de dados com os "valores"
for nome, valores in df.iteritems():
    break

#=============================================

print("=" * 80)
print("===========>> Iniciando consultas - Aguarde")
print("=" * 80)

counter = 0
counter_success = 0
erro_caracteres = 0
ceps_inexistentes = []
cep_qnt_invalida = []


'''
Percorre a lista com os CEPs faz a requisição e valida se existe todos os CEPs válidos.
'''
for cep in array_cep:

    if validaQuantidadeCaracteres(cep):
        erro_caracteres += 1
        cep_qnt_invalida.append(cep)

    # Faz a busca do cep na tupla "Valores" para ver se existe o CEP.
    if cep in valores.values:
        print('Localizou')
        counter_success += 1
    else:
        print(f'{cep} não Localizado');
        ceps_inexistentes.append(cep)
        counter += 1


print('*' * 30)
print(f'CEPs com caracteres inválidos: {erro_caracteres}')
print(f'LISTA de CEPs com quantidade de caracteres incorretos: {cep_qnt_invalida}')
print('*' * 30)
print(f'A quantidade de CEPs não encontrados no WebService foi de: {counter}')
print(f'LISTA de CEPs inexistentes no WebService: {ceps_inexistentes}')
print('*' * 30)
print(f'Total de CEP localizados com sucesso: {counter_success}')
print("--- Tempo de execução: %s segundos ---" % (time.time() - tempo_inicial))


