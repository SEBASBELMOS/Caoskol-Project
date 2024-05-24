import sys
from pyspark.sql import SparkSession


def main():
    # Inicia la sesión de Spark
    spark = SparkSession.builder.appName("ConsoleAnalysis").getOrCreate()

    # Carga los datos
    df = spark.read.csv("/root/Caoskol-Project/US_Dataset_users.csv", header=True, inferSchema=True)

    # Realiza operaciones, por ejemplo, un agregado
    result_df = df.groupBy("grado").count()

    # Guarda los resultados en un archivo
    result_df.write.csv("/root/Caoskol-Project/results.csv", mode="overwrite", header=True)

    # Detiene la sesión de Spark
    spark.stop()

if __name__ == "__main__":
    main()
