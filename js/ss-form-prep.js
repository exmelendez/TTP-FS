let symbolInput, symbol, cost, qty, coName;

    const _ = (x) => {
    	return document.getElementById(x);
    };

    const processPhase1 = () => {
      _("stat-msg").innerHTML = "";
    	symbolInput = _("symbol-inp").value;

      if (symbolInput.length == 0) {
        alert("Field must be filled in");
      } else {
        getStockInfo(symbolInput).catch(error => {
          _("stat-msg").innerHTML = "Symbol not found";
          console.error(error)
        });
      }
    };

    const processPhase2 = () => {
      _("stat-msg").innerHTML = "";
      qty = parseInt(_("qty-inp").value);
      totalMath = qty * cost;
      total = totalMath.toFixed(2);

    	if(qty > 0){
    		_("phase2").style.display = "none";
    		_("show_all_data").style.display = "block";
        _("display_co").innerHTML = coName;
    		_("display_symbol").innerHTML = symbol;
    		_("display_price").innerHTML = `$${cost}`;
    		_("display_qty").innerHTML = qty;
        _("display_total").innerHTML = `$${total}`;
    	} else {
    	    _("stat-msg").innerHTML = "Only whole numbers that are higher than 0";
    	}
    };

    const submitForm = () => {
    	_("multiphase").method = "post";
    	_("multiphase").submit();
    };

  const resetForm = () => {
    _("stat-msg").innerHTML = "";
    _("multiphase").reset();
    _("phase1").style.display = "block";
    _("phase2").style.display = "none";
    _("show_all_data").style.display = "none";
  };

  const getStockInfo = async(input) => {
    const response = await fetch("https://cloud.iexapis.com/stable/stock/" + input + "/quote?token=pk_0b24b9d449db422194decd95feda86d0");
    const data = await response.json();

      symbol = data['symbol'];
      cost = data['latestPrice'];
      coName = data['companyName'];

      _("symbol").setAttribute('value', symbol);
      _("coName").setAttribute('value', coName);
      _("cost").setAttribute('value', cost);

      _("phase1").style.display = "none";
      _("qty-inp").autofocus = true;
      _("phase2").style.display = "block";

  };

  const symbolData = async () => {
    const response = await fetch("https://api.iextrading.com/1.0/ref-data/symbols");
    const data = await response.json();
    console.log(data);
  };
