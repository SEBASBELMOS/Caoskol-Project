import pandas as pd

# Cargar los datos desde el archivo CSV
df = pd.read_csv('C:/Users/sebas/Documents/GitHub/Caoskol-Project/US_Dataset.csv')

# Seleccionar y renombrar las columnas necesarias
df = df[['nombre', 'grado']]

# Agregar las columnas para 'clave' y 'rol'
df['clave'] = '1234'
df['rol'] = 'Estudiante'

# Agregar una columna de 'id'
df['id'] = range(1, len(df) + 1)

# Reordenar las columnas para ajustarse al formato de SQL
df = df[['id', 'nombre', 'grado', 'clave', 'rol']]

# Guardar el nuevo DataFrame en un CSV
df.to_csv('C:/Users/sebas/Documents/GitHub/Caoskol-Project/US_Dataset_users.csv', index=False)

print("El archivo ha sido modificado y guardado exitosamente.")
