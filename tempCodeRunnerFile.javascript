function diaSemana(data) {
  const diasSemana = ['domingo', 'segunda', 'terca', "quarta", "quinta", "sexta", "sabado"]
  
  const dia = new Date(data)
console.log(dia, ", aqui eh minha data bruta")

  const indexDia = dia.getDay()
console.log(indexDia, ', aqui eh o dia da semana em numero')
  
  return diasSemana[indexDia]
}

const result = diaSemana('12/08/2022')
console.log(result,)
