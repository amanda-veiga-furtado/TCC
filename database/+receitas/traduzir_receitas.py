import json
from deep_translator import GoogleTranslator

# Carregar arquivo original
with open('big-recipe-database.json', 'r', encoding='utf-8') as f:
    dados = json.load(f)

# Pegar os 10 primeiros
primeiros_10 = dados[:10]
restante = dados[10:]

tradutor = GoogleTranslator(source='en', target='pt')

def traduzir_receita(receita):
    return {
        "title": tradutor.translate(receita["title"]),
        "ingredients": [tradutor.translate(i) for i in receita["ingredients"]],
        "directions": [tradutor.translate(d) for d in receita["directions"]]
    }

# Traduzir os 10 primeiros
traduzidos = [traduzir_receita(r) for r in primeiros_10]

# Salvar novo arquivo traduzido
with open('receitas_traduzidas.json', 'w', encoding='utf-8') as f:
    json.dump(traduzidos, f, ensure_ascii=False, indent=2)

# Atualizar arquivo original (removendo os 10 primeiros)
with open('receitas.json', 'w', encoding='utf-8') as f:
    json.dump(restante, f, ensure_ascii=False, indent=2)

print("Processo concluído!")