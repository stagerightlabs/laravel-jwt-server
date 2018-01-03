'use strict'
const fs = require('fs')
const merge = require('webpack-merge')
const prodEnv = require('./prod.env')

let devEnv = {
  NODE_ENV: '"development"',
  API_URL: '"http://127.0.0.1:8000"'
}

// If there exists a ".env.js" file in the vue.js application root,
// Lets use those env values instead.
if (fs.existsSync('./.env.js')) {
  const localConfig = require('../.env.js')

  devEnv = merge(devEnv, localConfig)
}


module.exports = merge(prodEnv, devEnv)
