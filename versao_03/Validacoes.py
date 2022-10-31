class ValidacoesCep:

    def validaQuantidadeCaracteres(self, cep):
        if len(str(cep)) != 8:
            return False