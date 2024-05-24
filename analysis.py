import sys
from pyspark.sql import SparkSession
from pyspark.sql.functions import mean, stddev, min, max, avg, corr, col

def main():
    # Inicia la sesión de Spark
    spark = SparkSession.builder.appName("Data_Analysis").getOrCreate()

    # Carga los datos
    notas_df = spark.read.csv("/root/Caoskol-Project/US_Dataset.csv", header=True, inferSchema=True)

    # Imprimir los nombres de las columnas originales
    print("Nombres de columnas originales:", notas_df.columns)

    # Limpiar espacios en los nombres de las columnas
    notas_df = notas_df.toDF(*[c.replace(' ', '').replace(')', '').replace('(', '').replace('VALUES', '') for c in notas_df.columns])

    # Verificar los nombres de las columnas después de la limpieza
    print("Columnas después de la limpieza:", notas_df.columns)


    # Limpiar espacios en los nombres de las columnas, incluyendo espacios internos y paréntesis
    notas_df = notas_df.toDF(*[c.replace(' ', '').replace(')', '').replace('(', '') for c in notas_df.columns])

    # Verificar los nombres de las columnas después de la limpieza
    print("Columnas después de la limpieza:", notas_df.columns)

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

    # Calcula estadísticas generales
    general_stats = notas_df.agg(
        max("puntaje_mat").alias("max_math"),
        min("puntaje_mat").alias("min_math"),
        avg("puntaje_mat").alias("avg_math"),
        max("num_premios").alias("max_awards"),
        avg("num_premios").alias("avg_awards")
    )
    general_stats.show()

    # Distribución de Estudiantes por Grado
    estudiantes_por_grado = notas_df.groupBy('grado').count()
    estudiantes_por_grado.show()

    # Promedio de puntajes por grado
    promedio_por_grado = notas_df.groupBy('grado').agg(
        mean('puntaje_mat').alias('Promedio Matemáticas'),
        mean('puntaje_ing').alias('Promedio Inglés'),
        mean('puntaje_ciencias').alias('Promedio Ciencias')
    )
    promedio_por_grado.show()

    # Calcular la correlación entre el número de premios y cada puntaje
    correlacion = notas_df.select(
        corr('num_premios', 'puntaje_mat').alias('Correlación Premios-Matemáticas'),
        corr('num_premios', 'puntaje_ing').alias('Correlación Premios-Inglés'),
        corr('num_premios', 'puntaje_ciencias').alias('Correlación Premios-Ciencias')
    )
    correlacion.show()

    # Guarda los resultados en archivos
    general_stats.write.csv("/root/Caoskol-Project/general_stats_results", mode="overwrite", header=True)
    correlacion.write.csv("/root/Caoskol-Project/correlacion_results", mode="overwrite", header=True)
    promedio_por_grado.write.csv("/root/Caoskol-Project/promedio_por_grado_results", mode="overwrite", header=True)

    # Detiene la sesión de Spark
    spark.stop()

if __name__ == "__main__":
    main()
