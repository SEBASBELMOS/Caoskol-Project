#Estadísticas Descriptivas para Puntajes y Premios
from pyspark.sql.functions import mean, stddev, min, max, count

# Calcular estadísticas descriptivas
stats_df = notas_df.select(
    mean('puntaje_mat').alias('Promedio Matemáticas'),
    mean('puntaje_ing').alias('Promedio Inglés'),
    mean('puntaje_ciencias').alias('Promedio Ciencias'),
    mean('num_premios').alias('Promedio Premios'),
    stddev('puntaje_mat').alias('Desvío Estándar Matemáticas'),
    stddev('puntaje_ing').alias('Desvío Estándar Inglés'),
    stddev('puntaje_ciencias').alias('Desvío Estándar Ciencias'),
    stddev('num_premios').alias('Desvío Estándar Premios'),
    max('num_premios').alias('Máximo Premios'),
    min('num_premios').alias('Mínimo Premios')
)

stats_df.show()


#Distribución de Estudiantes por Grado
# Contar estudiantes por grado
estudiantes_por_grado = notas_df.groupBy('grado').count()
estudiantes_por_grado.show()


# Promedio de puntajes por grado
promedio_por_grado = notas_df.groupBy('grado').agg(
    mean('puntaje_mat').alias('Promedio Matemáticas'),
    mean('puntaje_ing').alias('Promedio Inglés'),
    mean('puntaje_ciencias').alias('Promedio Ciencias')
)
promedio_por_grado.show()


from pyspark.sql.functions import corr

# Calcular la correlación entre el número de premios y cada puntaje
correlacion = notas_df.select(
    corr('num_premios', 'puntaje_mat').alias('Correlación Premios-Matemáticas'),
    corr('num_premios', 'puntaje_ing').alias('Correlación Premios-Inglés'),
    corr('num_premios', 'puntaje_ciencias').alias('Correlación Premios-Ciencias')
)
correlacion.show()
