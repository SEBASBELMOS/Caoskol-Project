FROM node:20

WORKDIR /microUsuarios
COPY package.json .
RUN npm install

EXPOSE 3030

COPY . .
CMD npm start