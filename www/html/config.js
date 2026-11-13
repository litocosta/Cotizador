"use strict";

const fs = require("fs");
const path = require("path");

let settings;

module.exports = function cotizadorConfig(key) {
  const name = "COTIZADOR_" + key;
  const value = process.env[name];
  if (value !== undefined && value !== "") {
    return value;
  }

  if (settings === undefined) {
    const filename = path.join(__dirname, "..", "..", "config.local.json");
    let parsed = {};
    if (fs.existsSync(filename)) {
      const contents = fs.readFileSync(filename, "utf8");
      try {
        parsed = JSON.parse(contents);
      } catch (error) {
        if (!(error instanceof SyntaxError)) {
          throw error;
        }
        throw new Error("config.local.json contiene JSON invalido");
      }
    }
    if (parsed === null || typeof parsed !== "object" || Array.isArray(parsed)) {
      throw new Error("config.local.json debe contener un objeto JSON valido");
    }
    settings = parsed;
  }

  if (typeof settings[key] !== "string" || settings[key] === "") {
    throw new Error("Falta configurar " + name + " o su valor en config.local.json");
  }
  return settings[key];
};
