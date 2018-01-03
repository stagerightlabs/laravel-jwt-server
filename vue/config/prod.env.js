'use strict'
const fs = require('fs')
const merge = require('webpack-merge')
let prodEnv = {
  NODE_ENV: '"production"',
  API_URL: '"http://127.0.0.1:8000"'
}

if (fs.existsSync('./.env.js')) {
  const localEnv = require('../.env.js')

  prodEnv = merge(prodEnv, localEnv)
}

module.exports = prodEnv
