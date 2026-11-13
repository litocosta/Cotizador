"use strict";

const assert = require("node:assert/strict");
const { spawnSync } = require("node:child_process");
const fs = require("node:fs");
const os = require("node:os");
const path = require("node:path");
const { test } = require("node:test");

for (const runtime of ["node", "php"]) {
  test(runtime + ": configuracion local y variables de entorno", (t) => {
    const root = fs.mkdtempSync(path.join(os.tmpdir(), "cotizador-config-"));
    t.after(() => fs.rmSync(root, { recursive: true }));
    const webroot = path.join(root, "www", "html");
    fs.mkdirSync(webroot, { recursive: true });
    const extension = runtime === "node" ? "js" : "php";
    const helper = path.join(webroot, "config." + extension);
    fs.copyFileSync(path.join(__dirname, "..", "www", "html", "config." + extension), helper);
    const filename = path.join(root, "config.local.json");

    function run(value) {
      const env = { ...process.env };
      delete env.COTIZADOR_TEST_VALUE;
      if (value !== undefined) {
        env.COTIZADOR_TEST_VALUE = value;
      }
      const result = runtime === "node"
        ? spawnSync(process.execPath, ["-e",
          'process.stdout.write(require(process.argv[1])("TEST_VALUE"))', helper],
        { env, encoding: "utf8" })
        : spawnSync(process.env.PHP_BINARY || "php", ["-r",
          'require $argv[1]; echo cotizador_config("TEST_VALUE");', helper],
        { env, encoding: "utf8" });
      assert.ifError(result.error);
      return result;
    }

    let result = run();
    assert.notEqual(result.status, 0);
    assert.match(result.stderr + result.stdout, /COTIZADOR_TEST_VALUE/);

    fs.writeFileSync(filename, JSON.stringify({ TEST_VALUE: "local-value" }));
    result = run();
    assert.equal(result.status, 0, result.stderr);
    assert.equal(result.stdout, "local-value");
    result = run("environment-value");
    assert.equal(result.status, 0, result.stderr);
    assert.equal(result.stdout, "environment-value");
    assert.equal(run("").stdout, "local-value");

    for (const invalid of [{ TEST_VALUE: "" }, { TEST_VALUE: 123 }, null, []]) {
      fs.writeFileSync(filename, JSON.stringify(invalid));
      result = run();
      assert.notEqual(result.status, 0);
      assert.match(result.stderr + result.stdout, /config\.local\.json/);
    }

    fs.writeFileSync(filename, '{"TEST_VALUE":"never-show-this-private-value",}');
    result = run();
    assert.notEqual(result.status, 0);
    assert.match(result.stderr + result.stdout, /config\.local\.json/);
    assert.doesNotMatch(result.stderr + result.stdout, /never-show-this-private-value/);
    assert.equal(run("environment-value").stdout, "environment-value");
  });
}
