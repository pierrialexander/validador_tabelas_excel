import requests
array_cep = ['20090002', '89560132', '89160033', '88010901', '2713680', '22713680', '40415165', '713680', '271360']

counter = 0
erro_caracteres = 0
ceps_inexistentes = []
cep_qnt_invalida = []

'''
Percorre a lista com os CEPs faz a requisição e valida se existe todos os CEPs válidos.
'''
for cep in array_cep:
    if len(cep) != 8:
        erro_caracteres += 1
        cep_qnt_invalida.append(cep)

    link = f'https://viacep.com.br/ws/{cep}/json/'
    requisicao = requests.get(link)

    if requisicao.ok == False:
        counter += 1
        ceps_inexistentes.append(cep)
    else:
        print(f"{requisicao.json()['cep']} - {requisicao.json()['logradouro']}")

print('*' * 30)
print(f'CEPs com caracteres inválidos: {erro_caracteres}')
print(f'LISTA de CEPs com quantidade de caracteres incorretos: {cep_qnt_invalida}')
print('*' * 30)
print(f'A quantidade de CEPs não encontrados no WebService foi de: {counter}')
print(f'LISTA de CEPs inexistentes no WebService: {ceps_inexistentes}')
print('*' * 30)


