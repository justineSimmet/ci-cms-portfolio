function requireAll(r) { r.keys().forEach(r); }
requireAll(require.context('./', true, /\.(svg|png|jpeg|jpg|gif|pdf)$/));