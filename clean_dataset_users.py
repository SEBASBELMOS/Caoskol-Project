import csv

def generate_sql_script_grades(input_filename, output_filename='AdjustedGradesData.sql'):
    sql_script = "INSERT INTO notas (id, nombre, grado, clave) VALUES\n"
    
    try:
        with open(input_filename, newline='', encoding='utf-8') as csvfile:
            reader = csv.DictReader(csvfile)
            students = list(reader)  # Convertimos el iterador en lista para uso múltiple
            for i, row in enumerate(students, start=1):
                nombre = row['nombre']
                clave = '1234'  # Asignamos una contraseña fija
                try:
                    # Intentamos convertir el grado a entero
                    grado = int(float(row['grado']))
                except ValueError:
                    # Si hay un error (e.g., 'NULL'), asignamos NULL o un valor predeterminado
                    grado = 'NULL'  # O puedes usar un valor predeterminado como 0 o un valor específico

                sql_script += f"({row['id']}, '{nombre}', {grado}, '{clave}')"
                if i < len(students):
                    sql_script += ",\n"
                else:
                    sql_script += ";"
    except FileNotFoundError:
        print(f"Error: The file {input_filename} was not found.")
        return
    except Exception as e:
        print(f"An error occurred: {e}")
        return

    with open(output_filename, "w") as file:
        file.write(sql_script)

    print(f"SQL script for adjusted grades has been saved to {output_filename}")

# El nombre del archivo ya está proporcionado como 'US_Dataset_users.csv'
generate_sql_script_grades('US_Dataset_users.csv')
