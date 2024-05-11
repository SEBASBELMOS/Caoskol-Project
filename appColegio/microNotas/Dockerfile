FROM node:20

WORKDIR /microNotas
COPY package.json .
RUN npm install

EXPOSE 3031

COPY . .
CMD npm start