import csv
import random

def generate_sql_script(input_filename, output_filename='InsertFullDataNotas.sql'):
    sql_script = "INSERT INTO notas (id, nombre, grado, num_premios, programa, puntaje_mat, puntaje_ing, puntaje_ciencias) VALUES\n"
    
    # Leemos los datos desde un archivo CSV
    try:
        with open(input_filename, newline='', encoding='utf-8') as csvfile:
            reader = csv.DictReader(csvfile)
            for i, row in enumerate(reader, start=1):
                nombre = row['nombre']
                # Convertimos el grado de float a entero
                grado = int(float(row['grado']))
                num_premios = random.randint(0, 3)  # Número de premios de 0 a 3

                # Convertimos el nombre del programa en valores numéricos
                programa_nombre = row['programa'].strip()
                if programa_nombre == 'Academico':
                    programa = 0
                elif programa_nombre == 'Vocacional':
                    programa = 1
                elif programa_nombre == 'General':
                    programa = 3
                else:
                    raise ValueError("Programa desconocido en el dataset")

                puntaje_mat = random.randint(20, 100)
                puntaje_ing = random.randint(20, 100)
                puntaje_ciencias = random.randint(20, 100)

                # Añadimos al script
                sql_script += f"({i}, '{nombre}', {grado}, {num_premios}, {programa}, {puntaje_mat}, {puntaje_ing}, {puntaje_ciencias})"
                if i != 400:
                    sql_script += ",\n"
                else:
                    sql_script += ";"
    except FileNotFoundError:
        print(f"Error: The file {input_filename} was not found.")
        return
    except Exception as e:
        print(f"An error occurred: {e}")
        return

    # Escribimos el contenido en un archivo .sql
    with open(output_filename, "w") as file:
        file.write(sql_script)

    print(f"SQL script has been saved to {output_filename}")

# Solicitamos al usuario el archivo de entrada
input_file = input("Please enter the name of the input CSV file (e.g., students_data.csv): ")

# Llamada a la función para generar el script
generate_sql_script(input_file)
